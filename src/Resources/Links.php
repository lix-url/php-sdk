<?php

namespace Lix\Resources;

use Lix\DTO\Link;
use Lix\DTO\LinkShortenResult;
use Lix\DTO\ResponseMeta;
use Lix\DTO\UsageItem;
use Lix\Http\ApiClient;
use Lix\DTO\Links as LinksDto;

final readonly class Links
{
    public function __construct(private ApiClient $apiClient)
    { }

    public function create(
        string  $url,
        ?string $alias = null,
        ?string $title = null,
        ?int    $groupId = null,
        array   $tags = [],
        array   $meta = [],
        array   $utm = [],
        array   $trackingPixelIds = [],
        ?string $activeBeforeDatetime = null,
        ?string $password = null,
        bool    $isPublic = true,
    ): LinkShortenResult {
        $data = $this->apiClient->createLink(
            [
                'group_id'               => $groupId,
                'url'                    => $url,
                'alias'                  => $alias,
                'password'               => $password,
                'title'                  => $title,
                'tags'                   => $tags,
                'is_public'              => $isPublic,
                'tracking_pixel_ids'     => $trackingPixelIds,
                'meta'                   => $meta,
                'utm'                    => $utm,
                'active_before_datetime' => $activeBeforeDatetime,
            ]);

        return new LinkShortenResult(
            self::linkFromRequestData($data['data']),
            new UsageItem($data['usage']['limit'], $data['usage']['used'], $data['usage']['remaining']),
        );
    }

    public function update(
        int     $id,
        ?string $url = null,
        ?string $title = null,
        ?int    $groupId = null,
        array   $tags = [],
        array   $meta = [],
        array   $utm = [],
        array   $trackingPixelIds = [],
        ?string $activeBeforeDatetime = null,
        ?string $password = null,
        bool    $isPublic = true,
    ): LinkShortenResult {
        $data = $this->apiClient->updateLink(
            $id,
            [
                'group_id'               => $groupId,
                'url'                    => $url,
                'password'               => $password,
                'title'                  => $title,
                'tags'                   => $tags,
                'is_public'              => $isPublic,
                'tracking_pixel_ids'     => $trackingPixelIds,
                'meta'                   => $meta,
                'utm'                    => $utm,
                'active_before_datetime' => $activeBeforeDatetime,
            ]);

        return new LinkShortenResult(
            self::linkFromRequestData($data['data']),
            new UsageItem($data['usage']['limit'], $data['usage']['used'], $data['usage']['remaining']),
        );
    }

    public function get(int $id): Link
    {
        $data = $this->apiClient->getLink($id);
        return self::linkFromRequestData($data['data']);
    }

    public function delete(int $id): void
    {
        $this->apiClient->deleteLink($id);
    }

    public function list(?int $limit = null, ?int $fromId = null): LinksDto
    {
        $data = $this->apiClient->getLinks($limit, $fromId);

        $linkItems = [];

        foreach ($data['data'] as $linkData) {
            $linkItems[] = self::linkFromRequestData($linkData);
        }

        return new LinksDto(
            $linkItems,
            new ResponseMeta($data['meta']['total'], $data['meta']['limit'], $data['meta']['next_url']),
        );
    }

    public static function linkFromRequestData(array $linkData): Link
    {
        return new Link(
            $linkData['id'],
            $linkData['alias'],
            $linkData['url'],
            $linkData['short_url'],
            $linkData['title'],
            Groups::groupFromRequestData($linkData['group']),
            $linkData['tags'],
            $linkData['meta'],
            $linkData['is_public'],
            $linkData['created_datetime'],
            $linkData['active_before_datetime'],
            $linkData['deleted_datetime'],
        );
    }
}
