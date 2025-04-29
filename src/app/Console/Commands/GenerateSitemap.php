<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;
use App\Models\Post;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate sitemap.xml using XMLWriter';

    public function handle():void
    {
        $this->info('Generating sitemap using XMLWriter...');

        $this->generateCategorySitemap();
        $this->generatePostSitemaps();
        $this->generateSitemapIndex();

        $this->info('Sitemap generation completed.');
    }

    /** @var \XMLWriter $xmlWriter */
    private function generateCategorySitemap():void
    {
        $filePath = public_path('sitemap_categories.xml');
        $xmlWriter = new \XMLWriter();
        $xmlWriter->openURI($filePath);
        $xmlWriter->startDocument('1.0', 'UTF-8');
        $xmlWriter->startElement('urlset');
        $xmlWriter->writeAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

        $categories = Category::query()
            ->select('slug', 'parent_id', 'created_at' ,'updated_at')
            ->with('parent')
            ->where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('parent_id')
                ->orWhereHas('parent', function ($q) {
                    $q->where('is_active', true);
                });
            })
            ->get();
        foreach ($categories as $category) {

            $lastModified = $category->updated_at ?? $category->created_at ?? now();
            $params = $category->parent_id
                ? ['category' => $category->parent->slug, 'child' => $category->slug]
                : ['category' => $category->slug];

            $this->writeUrlElement(
                $xmlWriter,
                route('category.show', $params),
                $lastModified
            );
        }

        $xmlWriter->endElement();
        $xmlWriter->endDocument();
        $xmlWriter->flush();
    }

    private function generatePostSitemaps():void
    {
        $postCount = Post::count();
        $chunkSize = 2000;
        $part = 1;

        Post::query()->select('slug', 'category_id', 'created_at' ,'updated_at')
            ->with(['category.parent' => function ($query) {
                $query->select('id', 'slug', 'is_active');
            }])
            ->whereHas('category', function ($query) {
                $query->where('is_active', true)
                    ->whereHas('parent', function ($q) {
                        $q->where('is_active', true);
                    });
            })
            ->chunk($chunkSize, function ($posts) use (&$part) {
                $filePath = public_path("sitemap_posts_part_{$part}.xml");
                $xmlWriter = new \XMLWriter();
                $xmlWriter->openURI($filePath);
                $xmlWriter->startDocument('1.0', 'UTF-8');
                $xmlWriter->startElement('urlset');
                $xmlWriter->writeAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

                foreach ($posts as $post) {
                    if (!$post->category || !$post->category->parent) {
                        continue;
                    }

                    $lastModified = $post->updated_at ?? $post->created_at ?? now();
                    $params = [
                        'category' => $post->category->parent->slug,
                        'child'    => $post->category->slug,
                        'post'     => $post->slug,
                    ];

                    $this->writeUrlElement(
                        $xmlWriter,
                        route('post.show', $params),
                        $lastModified
                    );
                }

                $xmlWriter->endElement();
                $xmlWriter->endDocument();
                $xmlWriter->flush();

                $this->info("Generated sitemap_posts_part_{$part}.xml");
                $part++;
            });
    }

    private function generateSitemapIndex():void
    {
        $filePath = public_path('sitemap.xml');
        $xmlWriter = new \XMLWriter();
        $xmlWriter->openURI($filePath);
        $xmlWriter->startDocument('1.0', 'UTF-8');
        $xmlWriter->startElement('sitemapindex');
        $xmlWriter->writeAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

        $this->writeSitemapElement($xmlWriter, url('sitemap_categories.xml'));

        $postCount = Post::count();
        $parts = ceil($postCount / 2000);
        for ($i = 1; $i <= $parts; $i++) {
            $this->writeSitemapElement($xmlWriter, url("sitemap_posts_part_{$i}.xml"));
        }

        $xmlWriter->endElement();
        $xmlWriter->endDocument();
        $xmlWriter->flush();
    }

    private function writeUrlElement($xmlWriter, $loc, $lastmod = null):void
    {
        $xmlWriter->startElement('url');
        $xmlWriter->writeElement('loc', $loc);
        $xmlWriter->writeElement('lastmod', $lastmod->toAtomString());
        $xmlWriter->endElement();
    }

    private function writeSitemapElement($xmlWriter, $loc):void
    {
        $xmlWriter->startElement('sitemap');
        $xmlWriter->writeElement('loc', $loc);
        $xmlWriter->writeElement('lastmod', now()->toAtomString());
        $xmlWriter->endElement();
    }
}
