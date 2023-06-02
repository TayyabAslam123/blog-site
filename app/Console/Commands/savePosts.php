<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Site;
use App\Category;

class savePosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:saveposts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will call the api and get the categories and blog posts and save it';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $sites_for_categories = Site::where('is_category', 'inactive')->get();
        // dd($sites_for_categories);
        foreach($sites_for_categories as $site){
            // Initialize cURL
            $curl = curl_init();
            // Base URL
            $baseURL = $site->url;
            // Endpoint URL
            $endpointURL = "/wp-json/wp/v2/categories?per_page=100";
            // Concatenate the URLs
            $url = $baseURL . $endpointURL;
            // dd($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            // Set the request type to GET
            curl_setopt($curl, CURLOPT_HTTPGET, true);
            // Return the response instead of printing it
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            // Execute the request
            $response = curl_exec($curl);
            // Check for errors
            if(curl_errno($curl)){
                echo 'cURL error: ' . curl_error($curl);
            }
            // Close cURL
            curl_close($curl);

            ## SAVE THE CATEGORIES
            $response = json_decode($response, true);
            foreach ($response as $val) {
                Category::create([
                    'name'  => $val['name'],
                    'slug'   => $val['slug'],
                    'cat_id' => $val['id'],
                    'site_id' => $site->id
                ]);
            }

        }

        ## FETCH AND SAVE POST'S
        $sites_for_categories = Site::where('is_post', 'inactive')->get();

        echo 'END';


    }
}
