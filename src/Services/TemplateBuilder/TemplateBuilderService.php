<?php

namespace Mfarahani\TCrawl\Services\TemplateBuilder;

use Illuminate\Support\Str;
use Mfarahani\TCrawl\Helpers\NormalString;
use Mfarahani\TCrawl\Models\SourceTemplate;
use Mfarahani\TCrawl\Services\Crawl\CrwalerService;

class TemplateBuilderService
{

    /**
     * createTemplate function
     *
     * @param object $info
     * @param string $template
     * @return SourceTemplate
     */
    public function createTemplate(object $info, string $template): SourceTemplate
    {
        $SourceTemplate = SourceTemplate::create([
            'title'    => $info->title,
            'username' => Str::after($info->username, "@"),
            'url'      => CrwalerService::BASEURL . Str::after($info->username, "@"),
            'template' => base64_encode($template),
            'status'   => true,
        ]);

        return $SourceTemplate;
    }

    /**
     * updateTemplate function
     *
     * @param string $username
     * @param string $template
     * @param boolean $status
     * @return SourceTemplate
     */
    public function updateTemplate(string $username, string $template, bool $status): SourceTemplate
    {

        $SourceTemplate = SourceTemplate::where("username", $username)->update([
            'template' => base64_encode($template),
            'status'   => $status,
        ]);

        return $SourceTemplate;
    }

    /**
     * getTemplate function
     *
     * @param string $username
     * @return SourceTemplate|null
     */
    public function getTemplate(string $username): ?SourceTemplate
    {
        return SourceTemplate::where('username', $username)->first();
    }

    public function build(string $username, $message)
    {
        $sourceTemplate = SourceTemplate::where('username', $username)->first();
        $template       = (new NormalString($sourceTemplate->template))->decode()->iconv()->removeEmoji()->trim()->prepare();
        $message        = (new NormalString($message))->iconv()->removeEmoji()->trim()->prepare();

        $keys = $this->findKeysTemplate($template);

        $parts = preg_split('/\[(.*?)\]]/', $template);

        $msg = $message;

        foreach ($parts as $value) {
            $msg = str_replace($value, '^******^', $msg);
        }

        $values = explode('^******^', $msg);

        $values = array_filter($values);

        $values = array_values($values);

        $result = [];
        foreach ($keys as $k => $key) {
            $key = preg_replace('/\[(.*?)\]/', '$2 $1', $key);
            $key = preg_replace('/\[(.*?)\]/', '$2 $1', $key);
            $key = trim($key);

            $result[$key] = $values[$k];

        }

        return $result;
    }

    private function findKeysTemplate(string $string)
    {
        preg_match_all('/\[(.*?)\]]/', $string, $output_array);

        $keys = $output_array[0];

        return $keys;
    }

}
