<?php
    /**
     * Copyright (c) 2017 Nicolas GILLE
     *
     * Permission is hereby granted, free of charge, to any person obtaining a copy
     * of this software and associated documentation files (the "Software"), to deal
     * in the Software without restriction, including without limitation the rights
     * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
     * copies of the Software, and to permit persons to whom the Software is
     * furnished to do so, subject to the following conditions:
     *
     * The above copyright notice and this permission notice shall be included in all
     * copies or substantial portions of the Software.
     *
     * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
     * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
     * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
     * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
     * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
     * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
     * SOFTWARE.
     */

    declare(strict_types=1);

    namespace GravatarLibTest;

    use GravatarLib\Gravatar\Gravatar;
    use PHPUnit\Framework\TestCase;
    use Prophecy\Exception\InvalidArgumentException;

    /**
     * Class Test
     *
     * @author Nicolas GILLE
     * @package GravatarTest
     * @since 1.0
     * @version 1.0
     * @coversDefaultClass GravatarLib\Gravatar\Gravatar
     */
    class GravatarTest extends TestCase {

        /**
         * Instantiate default constructor.
         *
         * @covers Gravatar->constructor()
         * @since 1.0
         */
        public function testInstantiateDefaultConstructor() {
            // Given - Instantiate all expected values.
            $sizeExpected = 80;
            $defaultImageExpected = '';
            $ratingExpected = 'g';

            // When - Instantiate Gravatar Object.
            $gravatar = new Gravatar();

            // Then - compare default value for each attribute.
            $this->assertEquals($sizeExpected, $gravatar->getSize());
            $this->assertEquals($defaultImageExpected, $gravatar->getDefaultImage());
            $this->assertEquals($ratingExpected, $gravatar->getMaxRating());
            $this->assertFalse($gravatar->isSecureUri());
            $this->assertFalse($gravatar->isForceDefaultImage());
        }

        /**
         * Instantiate constructor with defaultImageExpected as a Gravatar value.
         *
         * @covers Gravatar->constructor()
         * @since 1.0
         */
        public function testInstantiateWithDefaultValueImage() {
            // Given - Instantiate all expected values.
            $sizeExpected = 120;
            $ratingExpected = 'pg';
            $defaultImageExpected = 'identicon';

            // When - Instantiate Gravatar Object.
            $gravatar = new Gravatar($sizeExpected, $defaultImageExpected, false, $ratingExpected, false);

            // Then - compare default value for each attribute.
            $this->assertEquals($sizeExpected, $gravatar->getSize());
            $this->assertEquals($defaultImageExpected, $gravatar->getDefaultImage());
            $this->assertEquals($ratingExpected, $gravatar->getMaxRating());
            $this->assertFalse($gravatar->isSecureUri());
            $this->assertFalse($gravatar->isForceDefaultImage());
        }

        /**
         * Instantiate constructor with defaultImageExpected as a valid uri.
         *
         * @covers Gravatar->constructor()
         * @since 1.0
         */
        public function testInstantiateWithDefaultUrlImage() {
            // Given - Instantiate all expected values.
            $sizeExpected = 120;
            $ratingExpected = 'pg';
            $defaultImageExpected = 'https://image.freepik.com/icones-gratuites/homme-avatar-sombre_318-9118.jpg';

            // When - Instantiate Gravatar Object.
            $gravatar = new Gravatar($sizeExpected, $defaultImageExpected, false, $ratingExpected, false);

            // Then - compare default value for each attribute.
            $this->assertEquals($sizeExpected, $gravatar->getSize());
            $this->assertEquals(rawurlencode($defaultImageExpected), $gravatar->getDefaultImage());
            $this->assertEquals($ratingExpected, $gravatar->getMaxRating());
            $this->assertFalse($gravatar->isSecureUri());
            $this->assertFalse($gravatar->isForceDefaultImage());
        }

        /**
         * Set size of avatar with invalid value.
         *
         * @covers Gravatar->setSize(int)
         * @expectedException InvalidArgumentException
         * @since 1.0
         */
        public function testThrowSuperiorSizeError() {
            // Given - Instantiate wrong size ($sizeExpected > Gravatar::MAX_SIZE || $sizeExpected < Gravatar::MIN_SIZE)
            $sizeExpected = Gravatar::MAX_SIZE + 1;
            $gravatar = new Gravatar();

            // When - Set size.
            // Then - Throw an InvalidArgumentException.
            $gravatar->setSize($sizeExpected);
        }

        /**
         * Set size of avatar with invalid value.
         *
         * @covers Gravatar->setSize(int)
         * @expectedException InvalidArgumentException
         * @expectedExceptionMessage The size must be within 0 and 2048
         * @since 1.0
         */
        public function testThrowInferiorSizeError() {
            // Given - Instantiate wrong size ($sizeExpected > Gravatar::MAX_SIZE || $sizeExpected < Gravatar::MIN_SIZE)
            $sizeExpected = Gravatar::MIN_SIZE - 1;
            $gravatar = new Gravatar();

            // When - Set size.
            // Then - Throw an InvalidArgumentException.
            $gravatar->setSize($sizeExpected);
        }

        /**
         * Throw an exception when you try to set invalid default image url.
         *
         * @covers Gravatar->setDefaultImage(string)
         * @expectedException InvalidArgumentException
         * @expectedExceptionMessage The default image specified is not a valid URL or present as default value in Gravatar.
         * @since 1.0
         */
        public function testThrowSetDefaultImageWithInvalidUrl() {
            // Given - Instantiate invalid url.
            $defaultImageExpected = "://0.gravatar.com/avatar/ad516503a11cd5ca435acc9bb6523536?s=256";
            $gravatar = new Gravatar();

            // When - Set DefaultImage
            // Then - Thrown an InvalidArgumentException
            $gravatar->setDefaultImage($defaultImageExpected);
        }

        /**
         * Throw an exception when you try to set invalid default image gravatar constant.
         *
         * @covers Gravatar->setDefaultImage(string)
         * @expectedException InvalidArgumentException
         * @expectedExceptionMessage The default image specified is not a valid URL or present as default value in Gravatar.
         * @since 1.0
         */
        public function testThrowSetDefaultImageWithInvalidGravatarConstant() {
            // Given - Instantiate invalid url.
            $defaultImageExpected = "403";
            $gravatar = new Gravatar();

            // When - Set DefaultImage
            // Then - Thrown an InvalidArgumentException
            $gravatar->setDefaultImage($defaultImageExpected);
        }

        /**
         * Throw an exception when you try to set invalid default image gravatar constant.
         *
         * @covers Gravatar->setMaxRating(string)
         * @expectedException InvalidArgumentException
         * @expectedExceptionMessage The rating specified is invalid. Use only "g", "pg", "r" or "x" value.
         * @since 1.0
         */
        public function testThrowSetRatingWithInvalidConstant() {
            // Given - Instantiate invalid url.
            $ratingExpected = 'p';
            $gravatar = new Gravatar();

            // When - Set MaxRating
            // Then - Thrown an InvalidArgumentException
            $gravatar->setMaxRating($ratingExpected);
        }

        /**
         * Build the gravatar uri to show avatar.
         *
         * @covers Gravatar->buildGravatarUri(string, bool)
         * @since 1.0
         */
        public function testbuildGravatarUri() {
            // Given - Instantiate Gravatar object.
            $gravatar = new Gravatar();
            $mail = 'nic.gille@gmail.com';
            $uriExpected = 'http://www.gravatar.com/avatar/ceaac5a38484c84251076c359cbf2ab2?s=80;r=g';

            // When - Build uri.
            $uri = $gravatar->buildGravatarUri($mail);

            // Then - Compare uriExpected and uri.
            $this->assertEquals($uriExpected, $uri);
        }

        /**
         * Build the gravatar uri to show avatar.
         *
         * @covers Gravatar->buildGravatarUri(string, bool)
         * @since 1.0
         */
        public function testBuildSpecificGravatarUri() {
            // Given - Instantiate all expected values.
            $sizeExpected = 120;
            $ratingExpected = 'pg';
            $defaultImageExpected = 'identicon';
            $gravatar = new Gravatar($sizeExpected, $defaultImageExpected, false, $ratingExpected, false);
            $mail = 'nic.gille@gmail.com';
            $uriExpected = 'http://www.gravatar.com/avatar/ceaac5a38484c84251076c359cbf2ab2?s=120;r=pg;d=identicon';

            // Then - Build uri.
            $uri = $gravatar->buildGravatarUri($mail);

            // Then - Compare uriExpected and uri.
            $this->assertEquals($uriExpected, $uri);
        }
    }
