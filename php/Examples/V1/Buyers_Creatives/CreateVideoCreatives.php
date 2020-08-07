<?php

/**
 * Copyright 2020 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *    https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Ads\AuthorizedBuyers\RealTimeBidding\Examples\V1\Buyers_Creatives;

use Google\Ads\AuthorizedBuyers\RealTimeBidding\ExampleUtil\BaseExample;
use Google\Ads\AuthorizedBuyers\RealTimeBidding\ExampleUtil\Config;
use Google_Service_RealTimeBidding_Creative;
use Google_Service_RealTimeBidding_VideoContent;

/**
 * This example illustrates how to create video creatives for a given buyer account.
 */
class CreateVideoCreatives extends BaseExample
{

    public function __construct($client)
    {
        $this->service = Config::getGoogleServiceRealTimeBidding($client);
    }

    /**
     * @see BaseExample::getInputParameters()
     */
    protected function getInputParameters()
    {
        return [
            [
                'name' => 'account_id',
                'display' => 'Account ID',
               'description' =>
                    'The resource ID of the buyers resource under which the creative is to be ' .
                    'created.',
                'required' => true
            ],
            [
                'name' => 'advertiser_name',
                'display' => 'Advertiser name',
                'description' => 'The name of the company being advertised in the creative.',
                'required' => false,
                'default' => 'Test'
            ],
            [
                'name' => 'creative_id',
                'display' => 'Creative ID',
                'description' =>
                    'The user-specified creative ID. The maximum length of the creative ID is ' .
                    '128 bytes',
                'required' => false,
                'default' => 'Video_Creative_' . uniqid()
            ],
            [
                'name' => 'declared_attributes',
                'display' => 'Declared attributes',
                'description' =>
                    'The creative attributes being declared. Specify each attribute separated ' .
                    'by a comma.',
                'required' => false,
                'is_array' => true,
                'default' => ['CREATIVE_TYPE_VAST_VIDEO']
            ],
            [
                'name' => 'declared_click_urls',
                'display' => 'Declared click URLs',
                'description' =>
                    'The click-through URLs being declared. Specify each URL separated by a comma.',
                'required' => false,
                'is_array' => true,
                'default' => ['http://test.com']
            ],
            [
                'name' => 'declared_restricted_categories',
                'display' => 'Declared restricted categories',
                'description' =>
                    'The restricted categories being declared. Specify each category separated ' .
                    'by a comma.',
                'required' => false,
                'is_array' => true
            ],
            [
                'name' => 'declared_vendor_ids',
                'display' => 'Declared vendor IDs',
                'description' =>
                    'The vendor IDs being declared. Specify each ID separated by a comma.',
                'required' => false,
                'is_array' => true
            ],
            [
                'name' => 'video_url',
                'display' => 'Video URL',
                'description' => 'The URL to fetch a video ad.',
                'required' => false,
                'default' => 'https://video.test.com/ads?id=123456&wprice=%%WINNING_PRICE%%'
            ]
        ];
    }

    /**
     * @see BaseExample::run()
     */
    public function run()
    {
        $values = $this->formValues;
        $parentName = "buyers/$values[account_id]";

        $video = new Google_Service_RealTimeBidding_VideoContent();
        $video->videoUrl = $values['video_url'];

        $newCreative = new Google_Service_RealTimeBidding_Creative();
        $newCreative->advertiserName = $values['advertiser_name'];
        $newCreative->creativeId = $values['creative_id'];
        $newCreative->declaredAttributes = $values['declared_attributes'];
        $newCreative->declaredClickThroughUrls = $values['declared_click_urls'];
        $newCreative->declaredRestrictedCategories = $values['declared_restricted_categories'];
        $newCreative->declaredVendorIds = $values['declared_vendor_ids'];
        $newCreative->setVideo($video);

        print "<h2>Creating Creative for '$parentName':</h2>";
        $result = $this->service->buyers_creatives->create($parentName, $newCreative);
        $this->printResult($result);
    }

    /**
     * @see BaseExample::getName()
     */
    public function getName()
    {
        return 'Create Buyer Video Creative';
    }
}
