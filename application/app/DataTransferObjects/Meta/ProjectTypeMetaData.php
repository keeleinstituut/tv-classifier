<?php

namespace App\DataTransferObjects\Meta;

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
