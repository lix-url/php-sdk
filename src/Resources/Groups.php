<?php

namespace Lix\Resources;

use Lix\DTO\Group;
use Lix\DTO\ResponseMeta;
use Lix\Http\ApiClient;
use Lix\DTO\Groups as GroupsDto;

final readonly class Groups
{
    public function __construct(private ApiClient $apiClient)
    { }

    public function create(
        string  $name,
        ?string $description = null,
        bool    $isRotate = false,
    ): Group {
        $data = $this->apiClient->createGroup(
            [
                'name'        => $name,
                'description' => $description,
                'is_rotate'   => $isRotate
            ]);

        return self::groupFromRequestData($data['data']);
    }

    public function update(
        int     $groupId,
        ?string $name = null,
        ?string $description = null,
        bool    $isRotate = false,
    ): Group {
        $data = $this->apiClient->updateGroup(
            $groupId,
            [
                'name'        => $name,
                'description' => $description,
                'is_rotate'   => $isRotate
            ]);

        return self::groupFromRequestData($data['data']);
    }

    public function get(int $id): Group
    {
        $data = $this->apiClient->getGroup($id);
        return self::groupFromRequestData($data['data']);
    }

    public function delete(int $id): void
    {
        $this->apiClient->deleteGroup($id);
    }

    public function list(?int $limit = null, ?int $fromId = null): GroupsDto
    {
        $data = $this->apiClient->getGroups($limit, $fromId);

        $groupItems = [];

        foreach ($data['data'] as $groupItem) {
            $groupItems[] = self::groupFromRequestData($groupItem);
        }

        return new GroupsDto(
            $groupItems,
            new ResponseMeta($data['meta']['total'], $data['meta']['limit'], $data['meta']['next_url']),
        );
    }

    public static function groupFromRequestData(?array $groupData): ?Group
    {
        if (!$groupData) {
            return null;
        }

        return new Group(
            $groupData['id'],
            $groupData['alias'],
            $groupData['url'],
            $groupData['name'],
            $groupData['is_rotate'],
            $groupData['description'],
            $groupData['created_datetime'],
            $groupData['deactivated_datetime'],
        );
    }
}
