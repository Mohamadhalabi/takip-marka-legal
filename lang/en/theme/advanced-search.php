<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Classes Language Lines
    |--------------------------------------------------------------------------
    */

    'title' => 'ADVANCED SEARCH',
    'subtitle-1' => 'EXACT MATCH FEATURE',
    'subtitle-1-description' => '<p>Trademark Legal Tracking retrieves similar keywords in the search results. Not missing similar trademarks is a desired feature in most cases, but sometimes you may want the system to only bring exact matches and not consider similarity features for that particular trademark. In this case, you can use the exact match feature.<br><br>The system understands the exact match feature with quotation marks (" "). When an expression is placed between two quotation marks, it is interpreted as an exact match, and only the trademarks that exactly match the inserted expression are included in the results. To use the exact match feature, you can use two pairs of double quotation marks in your trademark or click on the "exact match" box during brand entry.</p>',
    'subtitle-2' => 'Exact match search with exact match feature',
    'subtitle-2-description' => '<p>Some brand owners are not interested in objecting to similar brands and only want to see it if there is an exact match for the brand. In this case, using the exact match feature for the entire brand is an appropriate option.</p>',
    'subtitle-2-description-2' => '<p>We can set this by typing our brand in the brand entry field and checking the exact match box.</p>',
    'subtitle-3' => 'Requiring specific words with exact match feature',
    'subtitle-3-description' => '<p>Some brands consist of several words. For brands that contain three or more words, the system does not require all words to be included in the results. In this case, there may be certain words that you definitely want to be included in the match. For example, let\'s consider a three-word brand like <strong>electric trade industry</strong>. If we are not interested only in <strong>trade industry</strong> in the results, we can require the word <strong>electric</strong> to be included in the results.</p>',
    'subtitle-3-description-2' => '<p>Let\'s modify the search to <strong>"electric" trade industry</strong>.</p>',
    'subtitle-4' => 'Filtering word matches with exact match feature',
    'subtitle-4-description' => '<p>Some words, especially short words, can be similar to many other words. Let\'s consider the word "marka" (brand). If it frequently matches similar words like "market" in each bulletin, but we are not interested in any of them, we can use the exact match feature to filter out all irrelevant matches.</p>',
    'subtitle-4-description-2' => '<p>Now let\'s search again by including the word <strong>marka</strong> in the exact match.</p>',
    'subtitle-5' => 'Blocking specific similarities with exact match feature',
    'subtitle-5-description' => '<p>The exact match feature can also be applied to only specific characters within a word. In this case, the results that do not have an exact match for the phrase inside the quotation marks are filtered out.</p>',
    'subtitle-5-description-2' => '<p>Sometimes, including a character in the exact match based on your search keyword can bring the desired results.</p>',
    'subtitle-5-description-3' => '<p>Now let\'s search for the keyword <strong>okulları</strong> and see the results.</p>',
    'subtitle-5-description-4' => '<p>We encountered unwanted results due to the similarity between <strong>okullar-oğullar</strong>. This is because of the similarity between the letters <strong>k-ğ</strong>.</p>',
    'subtitle-5-description-5' => '<p>Let\'s change our keyword to <strong>o"k"ullar</strong> and search again.</p>',
    'subtitle-5-description-6' => '<p>As seen in the results, unwanted results are filtered out due to the similarity between k-ğ.</p>',
    'subtitle-6' => 'EXCLUDED WORDS',
    'subtitle-6-description' => '<p class="mt-4">You may want to exclude certain words from appearing in the search results. For this, you can use the excluded words filter.</p>',
    'subtitle-6-description-2' => '<p>If the excluded word you added is an exact match for any word in the search keyword, it will be filtered out and not shown to you.</p>',
    'subtitle-6-description-3' => '<p>You can use excluded words without the risk of missing the followed brand. Because excluded words are only considered for the word that matches the keyword, and the matching word must be exactly the same as the excluded word for the result to be filtered.</p>',
    'subtitle-6-description-4' => '<p>When filtering, when you search with an exact match, the searched text will appear exactly in the results. Even if the exact match is achieved, the matching word can have prefixes and suffixes.</p>',
    'subtitle-6-description-5' => '<p class="mt-4">Let\'s search for the keyword <strong>arteng</strong> without adding any excluded words.</p>',
    'subtitle-6-description-6' => '<p>Now let\'s add one excluded word to get clearer results.</p>',
    'subtitle-6-description-7' => '<p>In this example, we added one excluded word. Here, when you add an excluded word, the added word must exactly match with the matching word.</p>',
    'subtitle-6-description-8' => '<p>In the example, the brand number 2 with the word <strong>garden</strong> is not shown in the results because it is an exact match.</p>',
];