<?php 

namespace IndicoIo\Test;

class IndicoIoTest extends \PHPUnit_Framework_TestCase
{

    public function testPoliticalWhenGivenTheRightParameters()
    {
        $keys_exptected = array('Libertarian', 'Liberal', 'Green', 'Conservative');
        $data = \IndicoIo\IndicoIo::political('Obama is the USA president !!');
        $keys_result = array_keys($data);
        
        sort($keys_exptected);
        sort($keys_result);

        $this->assertEquals($keys_exptected, $keys_result);
    }

    public function testPoliticalReturnFullErrorMsgWhenGivenIntegerORBool()
    {
        $data_integer_request = \IndicoIo\IndicoIo::political(2);
        $data_bool_request    = \IndicoIo\IndicoIo::political(true);
        
        $this->assertArrayHasKey('Error', $data_integer_request);
        $this->assertGreaterThan(0, strlen($data_integer_request['Error']));

        $this->assertArrayHasKey('Error', $data_bool_request);
        $this->assertGreaterThan(0, strlen($data_bool_request['Error']));
    }

    public function testSentimentWhenGivenTheRightParameters()
    {
        $keys_exptected = array('Sentiment');
        $data = \IndicoIo\IndicoIo::sentiment('Obama is the USA president !!');
        $keys_result = array_keys($data);
        
        sort($keys_exptected);
        sort($keys_result);

        $this->assertEquals($keys_exptected, $keys_result);
    }


    public function testSentimentReturnValueBetweenOneAndZero()
    {
        $data = \IndicoIo\IndicoIo::sentiment('Obama is the USA president !!');
        $this->assertArrayHasKey('Sentiment', $data);
        // The returned must be between 0 and 1.
        $this->assertGreaterThan(0, $data['Sentiment']);
        $this->assertGreaterThan($data['Sentiment'], 1);
    }

    public function testLanguageWhenGivenTheRightPrameters()
    {
        $expected_languages = array(
            'English',
            'Spanish',
            'Tagalog',
            'Esperanto',
            'French',
            'Chinese',
            'French',
            'Bulgarian',
            'Latin',
            'Slovak',
            'Hebrew',
            'Russian',
            'German',
            'Japanese',
            'Korean',
            'Portuguese',
            'Italian',
            'Polish',
            'Turkish',
            'Dutch',
            'Arabic',
            'Persian (Farsi)',
            'Czech',
            'Swedish',
            'Indonesian',
            'Vietnamese',
            'Romanian',
            'Greek',
            'Danish',
            'Hungarian',
            'Thai',
            'Finnish',
            'Norwegian',
            'Lithuanian'
        );

        $data = \IndicoIo\IndicoIo::language('bonsoir les jeunes !');
        $keys_result = array_keys($data);

        sort($expected_languages);
        sort($keys_result);

        $this->assertEmpty(array_diff($expected_languages, $keys_result));
    }

    public function testFerWhenGivenTheRightParameters()
    {
        $humour_expected = array('Angry', 'Sad', 'Neutral', 'Surprise', 'Fear', 'Happy');
        $file_content =  file_get_contents(dirname(__FILE__) .DIRECTORY_SEPARATOR.'/data_test.json');
        $data_test = json_decode($file_content, true);
        $image     = $data_test[0];
        $data = \IndicoIo\IndicoIo::fer($image);
        $keys_result = array_keys($data);

        sort($keys_result);
        sort($humour_expected);

        $this->assertEquals($humour_expected, $keys_result);
    }

    public function testfacialFeaturesWhenGivenTheRightParameters()
    {
        $file_content =  file_get_contents(dirname(__FILE__) .DIRECTORY_SEPARATOR.'/data_test.json');
        $data_test = json_decode($file_content, true);
        $image     = $data_test[0];
        $data = \IndicoIo\IndicoIo::facial_features($image);

        $this->assertEquals(count($data), 48);
    }
}