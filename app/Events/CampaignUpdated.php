<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class CampaignUpdated implements ShouldBroadcastNow
{
	protected $data;
	private $isDm;

	public function __construct(array $data, bool $isDm)
	{
		$this->data = $data;
		$this->isDm = $isDm;
	}

	public function broadcastOn()
	{
		return new PrivateChannel('campaign-' . ($this->isDm ? 'dm' : 'player') . '.'.$this->data['campaign']['id']);
	}

	public function broadcastWith()
	{
		return $this->data;
	}
}
