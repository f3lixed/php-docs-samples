<?php
/**
 * Copyright 2015 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\Samples\Language\Tests;

use Google\Cloud\Samples\Language\AnalyzeEverythingCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Unit Tests for TablesCommand.
 */
class AnalyzeEverythingCommandTest extends \PHPUnit_Framework_TestCase
{
    protected static $hasCredentials;
    private $commandTester;
    private $expectedString;

    public static function setUpBeforeClass()
    {
        $path = getenv('GOOGLE_APPLICATION_CREDENTIALS');
        self::$hasCredentials = $path && file_exists($path) &&
            filesize($path) > 0;
    }

    public function setUp()
    {
        $application = new Application();
        $application->add(new AnalyzeEverythingCommand());
        $this->commandTester = new CommandTester($application->get('everything'));
        $this->expectedString = <<<EOF
language: en
sentiment: -0.3
sentences:
  0: Do you know the way to San Jose?
tokens:
  Do: VERB
  you: PRON
  know: VERB
  the: DET
  way: NOUN
  to: ADP
  San: NOUN
  Jose: NOUN
  ?: PUNCT
entities:
  San Jose: http://en.wikipedia.org/wiki/San_Jose,_California

EOF;
    }

    public function testEverything()
    {
        if (!self::$hasCredentials) {
            $this->markTestSkipped('No application credentials were found.');
        }

        $this->commandTester->execute(
            ['content' =>  explode(' ', 'Do you know the way to San Jose?')],
            ['interactive' => false]
        );

        $this->expectOutputString($this->expectedString);
    }

    public function testEverythingFromStorageObject()
    {
        if (!self::$hasCredentials) {
            $this->markTestSkipped('No application credentials were found.');
        }
        if (!$gcsFile = getenv('GOOGLE_LANGUAGE_GCS_FILE')) {
            $this->markTestSkipped('No GCS file.');
        }

        $this->commandTester->execute(
            ['content' =>  $gcsFile],
            ['interactive' => false]
        );

        $this->expectOutputString($this->expectedString);
    }
}
