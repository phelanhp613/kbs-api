<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Services\PortersJobService;

class CreateSitemapJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $sitemap;
    public $start;
    public $count;

    public function __construct($sitemap = null, $start = 1, $count = 200)
    {
        $this->sitemap = $sitemap;
        $this->start = $start;
        $this->count = $count;
    }

    public function handle(PortersJobService $portersJobService)
    {
        $sentry = app('sentry');
        try {
            $url = env('SITEMAP_URL');

            if(empty($this->sitemap)) {
                $this->sitemap = Sitemap::create()
                    ->add(Url::create($url)
                        ->setChangeFrequency(""));
            }

            $query['partition'] = config('porters.partition');
            $query['field'] = 'Job.P_Id,Job.P_Position,Job.U_C4DE70AFFDEFB7A9364C6F2FC5978A'; // U_C4DE70AFFDEFB7A9364C6F2FC5978A :  Position (VN)
            $query['count'] = $this->count;
            $query['start'] = $this->start;
            $query['condition'] = 'Job.U_E7CDAADF64C594979A66A915AA1CD5=Option.U_000059'; // get job Nationality VN
            $query['order'] = 'Job.P_UpdateDate:desc';
            $queryString = http_build_query($query);
            $data = $portersJobService->fetchJob($queryString);
            $data = get_object_vars($data);

            if ($data['Code'] == 0 && !empty($data['Item'])) {
                foreach ($data['Item'] as $job) {
                    $titleVn = $job->{'Job.U_C4DE70AFFDEFB7A9364C6F2FC5978A'};
                    $id = $job->{'Job.P_Id'};
                    if(!empty($titleVn->__toString())) {
                        $this->sitemap->add(Url::create($url . '/' . toSlug($titleVn->__toString()) . '-' . $id->__toString())
                            ->setChangeFrequency(""));
                    }
                }
            }

            if ($data['Code'] == 0 && $data['@attributes']['Total'] > ($data['@attributes']['Count'] + $data['@attributes']['Start'])) {
                dispatch(new CreateSitemapJob($this->sitemap, $this->start + 200, $this->count));
                dump("new job", $data['@attributes']);
                return;
            }

            $this->sitemap->writeToFile(public_path('sitemap.xml'));

            $sentry->captureMessage("Create sitemap Done!!!!!");
        } catch (\Exception $exception) {
            $sentry->captureException($exception);
        }
    }
}
