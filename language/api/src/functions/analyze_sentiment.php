<?php
/*
 * Copyright 2016 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * For instructions on how to run the full sample:
 *
 * @see https://github.com/GoogleCloudPlatform/php-docs-samples/tree/master/language/README.md
 */

namespace Google\Cloud\Samples\Language;

# [START analyze_sentiment]
use Google\Cloud\NaturalLanguage\NaturalLanguageClient;
use Google\Cloud\NaturalLanguage\Annotation;
use Google\Cloud\Storage\StorageObject;

/**
 * Find the sentiment in text.
 * ```
 * analyze_sentiment('Do you know the way to San Jose?');
 * analyze_sentiment($storageObject);
 * ```
 *
 * @param string|StorageObject $content The content to analyze.
 *
 * @return Annotation
 */
function analyze_sentiment($content, $options = [])
{
    $language = new NaturalLanguageClient();
    $annotation = $language->analyzeSentiment($content);
    return $annotation;
}
# [END analyze_sentiment]
