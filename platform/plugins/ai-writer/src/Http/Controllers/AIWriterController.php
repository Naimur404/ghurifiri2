<?php

namespace Botble\AIWriter\Http\Controllers;

use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Illuminate\Http\Request;
use Orhanerday\OpenAi\OpenAi;

class AIWriterController extends BaseController
{
    public function ajaxGetAIContent(Request $request, BaseHttpResponse $response)
    {
        abort_unless($request->ajax(), 404);

        $apiKey = setting('openai_api_key', '');

        if (empty($apiKey)) {
            $apiKey = env('OPEN_API_KEY', '');
        }

        if (empty($apiKey)) {
            return $response
                ->setError()
                ->setCode(403)
                ->setMessage('OpenAI API key invalid, you need to setting in Setting first');
        }

        $limitText = setting('openai_limit_text', 256);
        $keyword = $request->input('keyword');
        $type = $request->input('type');
        $language = $request->input('language');
        $numberVariant = $request->input('variant', 1);
        $typeList = get_ai_writer_subjects();
        $prompt = "Write $numberVariant " . ($typeList[$type] ?? '') . " About $keyword";

        if ($language != 'English') {
            $prompt = "Translate this into $language: " . $prompt;
        }

        $openAi = new OpenAi($apiKey);
        $aiResult = $openAi->completion([
            'model' => 'gpt-3.5-turbo-instruct',
            'prompt' => $prompt,
            'max_tokens' => (int) $limitText,
            'temperature' => 0,
        ]);

        $result = json_decode($aiResult, true);

        if (! empty($result['choices']) && is_array($result['choices'])) {
            $content = '';

            foreach ($result['choices'] as $choice) {
                $content .= $choice['text'];
            }

            return $response->setData([
                'content' => $content,
            ]);
        } else {
            $errorMessage = 'Service OpenAI Temporarily Unavailable. Please try again later. ';
            $errorMessage .= isset($result['error']) ? $result['error']['message'] : $aiResult;

            return $response->setError()
                ->setCode(403)
                ->setMessage($errorMessage);
        }
    }
}
