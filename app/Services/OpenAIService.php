<?php

namespace App\Services;

use App\Enums\ImageGenerateProgressEnum;
use App\Services\Contracts\OpenAIServiceInterface;
use App\Traits\UpdatesImageTrait;
use Illuminate\Support\Facades\Log;
use App\Actions\CreateOpenAIPromptAction;
use OpenAI\Laravel\Exceptions\ApiKeyIsMissing;
use OpenAI\Exceptions\InvalidArgumentException;
use OpenAI\Exceptions\TransporterException;

class OpenAIService implements OpenAIServiceInterface
{
    use UpdatesImageTrait;
    private CreateOpenAIPromptAction $createPromt;

    public function __construct(CreateOpenAIPromptAction $createPromt)
    {
        $this->createPromt = $createPromt;
    }


    /**
     * @param  string  $keyword
     * @param  int  $id
     *
     * @return string|bool
     */
    public function generatePromptByKeywords(string $keyword, int $id): string|bool
    {
        try {
            $response = $this->createPromt->createPrompt($keyword);
            if (isset($response->choices[0]->text)){
                $this->updateImage($id, ["progress" => ImageGenerateProgressEnum::PROMPT]);
                return $response->choices[0]->text;
            }

            $error = "Expected prompt couldn't be created. Please try again.";
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
            Log::error("Unexpected error in OpenAI Prompt Processing: {$e->getMessage()}");
            $this->updateFailedImage($id, "Unexpected error in OpenAI Prompt Processing: {$e->getMessage()}");

            return false;
        }
    }
}
