<?php

namespace App\DataTransferObjects\Meta;

use OpenApi\Attributes as OA;

#[OA\Schema(
    required: ['workflow_id', 'display_start_time'],
    properties: [
        new OA\Property(property: 'workflow_id', type: 'string'),
        new OA\Property(property: 'display_start_time', type: 'boolean'),
    ],
    type: 'object'
)]
readonly class ProjectTypeMetaData
{
    public string $workflowId;

    public bool $displayStartTime;

    public function __construct(array $meta = null)
    {
        $this->workflowId = $meta['workflow_id'] ?? '';
        $this->displayStartTime = $meta['display_start_time'] ?? false;
    }

    public function toArray(): array
    {
        return [
            'workflow_id' => $this->workflowId,
            'display_start_time' => $this->displayStartTime,
        ];
    }
}
