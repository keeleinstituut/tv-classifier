<?php

namespace App\DataTransferObjects\Meta;

readonly class ProjectTypeMetaData
{
    public string $workflow_id;
    public bool $display_start_time;

    public function __construct(array $meta = null)
    {
        $this->workflow_id = $meta['workflow_id'] ?? '';
        $this->display_start_time = $meta['display_start_time'] ?? false;
    }

    public function toArray(): array
    {
        return [
            'workflow_id' => $this->workflow_id,
            'display_start_time' => $this->display_start_time
        ];
    }
}
