<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Post;

class RssReader implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Fetch RSS Feed
		$feed = file_get_contents( env('RSS_FEED','https://news.google.com/rss') );

		// Parse into readable object
		$feed = simplexml_load_string($feed);

		// Loop RSS conent, building upsert array
		$upsert = [];
		foreach($feed->channel->item as $item )
		{
			$upsert[] = [
				'title' => (string)$item->title,
				'slug' => Str::slug((string)$item->title),
				'guid' => (string)$item->guid,
				'content' => (string)$item->description,
				'user_id' => User::first()->id,
				'enabled' => true
			];
		}

		// If RSS items found, upsert into posts table
		if(!empty($upsert)){
			Post::upsert(
				$upsert,
				['guid'],
				['title','slug','content','user_id','enabled']
			);
		}

    }
}