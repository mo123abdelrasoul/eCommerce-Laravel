<?php

namespace App\Http\Controllers\Admin\Analytics;

use App\Http\Controllers\Controller;
use Google\Analytics\Data\V1beta\Client\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\RunReportRequest;
use Google\Analytics\Data\V1beta\Dimension;
use Google\Analytics\Data\V1beta\Metric;
use Google\Analytics\Data\V1beta\DateRange;
use Illuminate\Http\Request;

class GoogleAnalyticsController extends Controller
{
    public function dashboard()
    {
        $propertyId = 513371401;
        $client = new BetaAnalyticsDataClient([
            'credentials' => storage_path('app/google-analytics/google-analytics.json'),
        ]);

        $request = new RunReportRequest([
            'property' => 'properties/' . $propertyId,
            'dimensions' => [
                new Dimension(['name' => 'pageTitle']),
                new Dimension(['name' => 'pagePath']),
                new Dimension(['name' => 'country']),
            ],
            'metrics' => [
                new Metric(['name' => 'screenPageViews']),
                new Metric(['name' => 'activeUsers']),
            ],
            'date_ranges' => [
                new DateRange(['start_date' => '7daysAgo', 'end_date' => 'today'])
            ],
            'limit' => 100
        ]);

        $response = $client->runReport($request);

        $data = [];
        foreach ($response->getRows() as $row) {
            $data[] = [
                'pageTitle' => $row->getDimensionValues()[0]->getValue(),
                'pagePath'  => $row->getDimensionValues()[1]->getValue(),
                'country'   => $row->getDimensionValues()[2]->getValue(),
                'views'     => $row->getMetricValues()[0]->getValue(),
                'users'     => $row->getMetricValues()[1]->getValue(),
            ];
        }

        return view('admin.dashboard.analytics', compact('data'));
    }
}
