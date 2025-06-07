<?php

namespace App\Console\Commands;

use App\Models\Subcategory;
use Illuminate\Console\Command;

class ProcessDescription extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-description';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $subcategories = Subcategory::where('id', '>', 176)->get();

        foreach ($subcategories as $i => $subcategory) {
            $description = static::getParaphrasedDescription($subcategory->description);
            if (is_null($description) || empty($description)) {
                echo "[$i] - {$subcategory->name} - Ошибка\n";
                continue;
            }

            $subcategory->update(['description' => $description]);
            echo "[$i] - {$subcategory->name} - Описание успешно изменено\n";
        }
    }

    private static function extractTables(&$description): array
    {
        $tables = [];
        $pattern = '/<table[\s\S]*?<\/table>/i';
        $description = preg_replace_callback($pattern, function ($matches) use (&$tables) {
            $tables[] = $matches[0];
            return "[TABLE_PLACEHOLDER_" . (count($tables) - 1) . "]";
        }, $description);
        return $tables;
    }

    private static function restoreTables($text, $tables): string
    {
        foreach ($tables as $i => $table) {
            $text = str_replace("[TABLE_PLACEHOLDER_{$i}]", $table, $text);
        }
        return $text;
    }

    private static function getParaphrasedDescription($description): ?string
    {
        $tables = self::extractTables($description);
        $apiKey = env('OPENAI_API_KEY');
        $url = "https://api.openai.com/v1/chat/completions";

        $prompt = "Перефразируй следующее описание товара, сохранив его смысл: \"$description\"";

        $response = self::sendChatGPTRequest($url, $apiKey, $prompt);

        if (!$response) {
            return null;
        }

        $data = json_decode($response, true);

        // Проверка структуры ответа
        if (!isset($data['choices'][0]['message']['content'])) {
            return null;
        }

        $paraphrased = trim($data['choices'][0]['message']['content']);
        return self::restoreTables($paraphrased, $tables);
    }


    private static function sendChatGPTRequest($url, $apiKey, $prompt)
    {
        $headers = [
            "Authorization: Bearer $apiKey",
            "Content-Type: application/json"
        ];

        $postData = json_encode([
            "model" => "gpt-4",
            "messages" => [["role" => "user", "content" => $prompt]],
            "temperature" => 0.3
        ]);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}
