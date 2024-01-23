<?php

namespace App\Services;

use App\Actions\CreateImageByOpenAIAction;
use App\Enums\ImageGenerateProgressEnum;
use App\Services\Contracts\DALLEServiceInterface;

use App\Traits\UpdatesImageTrait;
use Illuminate\Support\Facades\Log;
use OpenAI\Laravel\Exceptions\ApiKeyIsMissing;
use OpenAI\Exceptions\InvalidArgumentException;
use OpenAI\Exceptions\TransporterException;

class DALLEService implements DALLEServiceInterface
{
    use UpdatesImageTrait;
    private CreateImageByOpenAIAction $createImg;

    public function __construct(CreateImageByOpenAIAction $createImg)
    {
        $this->createImg = $createImg;
    }


    /**
     * @param  string  $prompt
     * @param  int  $id
     *
     * @return string|bool
     */
    public function generateImage(string $prompt, int $id): string|bool
    {
        try {
            $response = $this->createImg->createImage($prompt);
            if (isset($response->data[0]->b64_json)){
                 $this->updateImage($id, ["progress" => ImageGenerateProgressEnum::IMAGE]);
                 return base64_decode($response->data[0]->b64_json);
            }

            $error = "Expected image couldn't be created. Please try again.";
            $this->updateFailedImage($id, $error);
            throw new \Exception($error);

        } catch (ApiKeyIsMissing $e) {
            Log::error("OpenAI API key is missing : {$e->getMessage()}");
            $this->updateFailedImage($id, "OpenAI API key is missing : {$e->getMessage()}");

            return false;
        } catch (InvalidArgumentException $e) {
            Log::error("Invalid Argument passed: {$e->getMessage()}");
            $this->updateFailedImage($id, "Invalid Argument passed: {$e->getMessage()}");

            return false;
        } catch (TransporterException $e) {
            Log::error("Transporter Exception Occured: {$e->getMessage()}");
            $this->updateFailedImage($id, "Transporter Exception Occured: {$e->getMessage()}");

            return false;
        } catch (\Exception $e) {
            Log::error("Unexpected error in OpenAI Image Creation: {$e->getMessage()}");
            $this->updateFailedImage($id, "Unexpected error in OpenAI Prompt Processing: {$e->getMessage()}");

            return false;
        }
    }
}
