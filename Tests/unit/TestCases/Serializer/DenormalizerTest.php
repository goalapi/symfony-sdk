<?php declare(strict_types=1);
/**
 * Author: Murat Erkenov
 * Date/Time: 12/8/16/9:10 PM
 *
 */

namespace GoalAPI\SDKBundle\Tests\unit\TestCases\Serializer;

use GoalAPI\SDKBundle\Serializer\Denormalizer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Serializer;

class DenormalizerTest extends TestCase
{
    public function testArrayDenormalization()
    {
        $data = (object)[
            'key' => 'value',
        ];

        $serializer = new Serializer(
            [
                new Denormalizer\ArrayDenormalizer(),
                new SampleDenormalizer(),
            ]
        );
        $this->assertTrue(
            $serializer->supportsDenormalization(
                [
                    $data,
                ],
                SampleObject::class.'[]'
            )
        );
        $this->assertFalse(
            $serializer->supportsDenormalization(
                $data,
                SampleObject::class.'[]'
            )
        );
        $this->assertFalse(
            $serializer->supportsDenormalization(
                [
                    $data,
                ],
                SampleObject::class
            )
        );
        $sampleObject = new SampleObject();
        $sampleObject->setProperty($data->key);
        $expectedObjects = [
            $sampleObject,
        ];
        $denormalizedObjects = $serializer->denormalize([$data], SampleObject::class.'[]');
        $this->assertEquals($expectedObjects, $denormalizedObjects);
    }
}

class SampleDenormalizer extends Denormalizer
{

    /**
     * @inheritdoc
     */
    public function denormalize($data,string $class, string $format = null, array $context = array())
    {
        $sampleObject = new SampleObject();
        $sampleObject->setProperty($data->key);

        return $sampleObject;
    }

    /**
     * @inheritdoc
     */
    public function supportsDenormalization($object,string $type, string $format = null)
    {
        if (!is_object($object)) {
            return false;
        }
        if (SampleObject::class != $type) {
            return false;
        }

        return true;
    }
}

class SampleObject
{

    /**
     * @var string
     */
    private $property;

    /**
     * @return string
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * @param string $property
     */
    public function setProperty($property)
    {
        $this->property = $property;
    }
}
