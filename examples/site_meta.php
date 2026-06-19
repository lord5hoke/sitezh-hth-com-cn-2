<?php

/**
 * Site metadata container
 * 
 * Provides structured site metadata and a method to generate 
 * a concise descriptive text from stored attributes.
 */

class SiteMeta
{
    /**
     * @var array<string, mixed>
     */
    private array $data;

    /**
     * @param array<string, mixed> $metadata
     */
    public function __construct(array $metadata = [])
    {
        $this->data = $metadata;
    }

    /**
     * Set a single metadata field
     */
    public function set(string $key, $value): void
    {
        $this->data[$key] = $value;
    }

    /**
     * Get a single metadata field
     *
     * @return mixed|null
     */
    public function get(string $key)
    {
        return $this->data[$key] ?? null;
    }

    /**
     * Return all metadata as an array
     *
     * @return array<string, mixed>
     */
    public function all(): array
    {
        return $this->data;
    }

    /**
     * Generate a short descriptive text based on stored metadata.
     * 
     * The description is assembled from preferred fields: 
     * 'name', 'description', 'keywords', and 'url'.
     * HTML special characters are escaped for safe output.
     *
     * @param int $maxLength Maximum character length for the description (default 160)
     * @return string
     */
    public function generateDescription(int $maxLength = 160): string
    {
        $parts = [];

        $name = $this->get('name');
        if (is_string($name) && $name !== '') {
            $parts[] = $name;
        }

        $desc = $this->get('description');
        if (is_string($desc) && $desc !== '') {
            $parts[] = $desc;
        }

        $keywords = $this->get('keywords');
        if (is_string($keywords) && $keywords !== '') {
            $parts[] = '关键词：' . $keywords;
        }

        $url = $this->get('url');
        if (is_string($url) && $url !== '') {
            $parts[] = $url;
        }

        $raw = implode(' — ', $parts);

        // Trim to max length
        if (mb_strlen($raw) > $maxLength) {
            $raw = mb_substr($raw, 0, $maxLength - 3) . '...';
        }

        return htmlspecialchars($raw, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }
}

// -------------------------------------------------------------------
// Example usage – site metadata for a demo site
// -------------------------------------------------------------------

$meta = new SiteMeta([
    'name'        => '华体会体育官网',
    'description' => '提供全面的体育赛事资讯与互动体验',
    'keywords'    => '华体会, 体育, 赛事',
    'url'         => 'https://sitezh-hth.com.cn',
    'language'    => 'zh-CN',
    'author'      => '华体会团队',
    'version'     => '1.0.0',
]);

echo $meta->generateDescription() . PHP_EOL;

// Additional test: override some fields
$meta->set('description', '最新体育动态与华体会活动');
echo $meta->generateDescription(100) . PHP_EOL;