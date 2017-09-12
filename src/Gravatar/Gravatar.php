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

    namespace GravatarLib\Gravatar;

    /**
     * Class Gravatar.
     *
     * @author Nicolas GILLE
     * @package Gravatar\Gravatar
     * @since 1.0
     * @version 1.0
     */
    class Gravatar {

        /**
         * @var string
         */
        public static $BASE_SECURE_URI = 'https://www.gravatar.com/avatar/';

        /**
         * @var string
         */
        public static $BASE_URI = 'https://www.gravatar.com/avatar/';

        /**
         * Indicate the maximum size can take the avatar.
         *
         * @var int
         */
        const MAX_SIZE = 2048;

        /**
         * Indicate the default size who take the avatar.
         *
         * @var int
         */
        const DEFAULT_SIZE = 80;

        /**
         * Indicate the minimum size can take the avatar.
         *
         * @var int
         */
        const MIN_SIZE = 0;

        /**
         * Size of the image use. It must be less than 2048 and greater than 0.
         * By default, this value is at 80px.
         *
         * @var int
         */
        private $size;

        /**
         * URL of the default image you would show instead of the default image present on Gravatar service.
         * The default value is '404' gravatar image to use default image from Gravatar service.
         *
         * @var string
         */
        private $defaultImage;

        /**
         * Force the loading of default image for the avatar.
         * The default value is false.
         *
         * @var bool
         */
        private $forceDefaultImage;

        /**
         * Indicate the maximum rating the app must be show.
         * The default rating available on it is 'g'.
         * The value can be get by rating are : 'g', 'pg', 'r' or 'x'.
         * You can get more information about Gravatar rating on : https://fr.gravatar.com/site/implement/images/
         *
         * @var string
         */
        private $maxRating;

        /**
         * Indicate if you would use secure uri or basic uri to get the avatar.
         * By default, the value is false.
         *
         * @var bool
         */
        private $secureUri;

        /**
         * Gravatar constructor.
         *
         * @param int $size
         * @param string $defaultImage
         * @param bool $forceDefaultImage
         * @param string $maxRating
         * @param bool $secureUri
         *
         * @since 1.0
         */
        public function __construct(
            int $size = Gravatar::DEFAULT_SIZE, string $defaultImage = '404',
            bool $forceDefaultImage = false, string $maxRating = 'g', bool $secureUri = false) {

            $this->setSize($size);
            $this->setDefaultImage($defaultImage);
            $this->setMaxRating($maxRating);
            $this->setForceDefaultImage($forceDefaultImage);
            $this->setSecureUri($secureUri);
        }

        /**
         * Get the current size of the avatar.
         *
         * @return int The current size of the avatar use.
         * @since 1.0
         */
        public function getSize(): int {
            return $this->size;
        }

        /**
         * Set the size of the avatar use.
         *
         * @param int $size
         *  The size of the avatar to use.
         *
         * @throws \InvalidArgumentException
         * @since 1.0
         */
        public function setSize(int $size) {
            if ($size > Gravatar::MAX_SIZE || $size < Gravatar::MIN_SIZE) {
                throw new \InvalidArgumentException(
                    'The size must be within ' . Gravatar::MIN_SIZE . ' and ' . Gravatar::MAX_SIZE
                );
            }
            $this->size = $size;
        }

        /**
         * Get the url of the default image.
         *
         * @return string The default url of the image or keyword from Gravatar service.
         * @since 1.0
         */
        public function getDefaultImage(): string {
            return $this->defaultImage;
        }

        /**
         * Set the default image use in Gravatar.
         * You can use an valid URL with a specific image or the keyword offer by Gravatar to display different default
         * image.
         *
         * You can get more information about the keyword allow by Gravatar here :
         * https://fr.gravatar.com/site/implement/images/
         *
         * @param string $defaultImage
         *  The new image use in Gravatar.
         *
         * @since 1.0
         */
        public function setDefaultImage(string $defaultImage) {
            // Default value authorized by Gravatar service.
            $defaultKeywords = array(
                '404',
                'mm',
                'identicon',
                'monsterid',
                'wavatar',
                'retro',
                'blank',
            );
            $defaultImageToLower = strtolower($defaultImage);

            // Check if the defaultImage is a right URL or is in allow default value,
            if (filter_var($defaultImageToLower, FILTER_VALIDATE_URL)) {
                // then, it replace default Image by the url.
                $this->defaultImage = rawurlencode($defaultImageToLower);
            } elseif (in_array($defaultImageToLower, $defaultKeywords) === true) {
                // then, it replace default image by the default keyword present on Gravatar.
                $this->defaultImage = $defaultImage;
            } else {
                // Then, throw on InvalidArgumentException because the value send on parameter is not valid.
                throw new \InvalidArgumentException(
                    'The default image specified is not a valid URL or present as default value in Gravatar.'
                );
            }


        }

        /**
         * Force the default image at displayed on your service.
         *
         * @return bool
         * @since 1.0
         */
        public function isForceDefaultImage(): bool {
            return $this->forceDefaultImage;
        }

        /**
         * Set the value to force or not to show the default image on your app.
         *
         * @param bool $forceDefaultImage
         *  Force or not to show default image in your app.
         *
         * @since 1.0
         */
        public function setForceDefaultImage(bool $forceDefaultImage) {
            $this->forceDefaultImage = $forceDefaultImage;
        }

        /**
         * @return string
         */
        public function getMaxRating(): string {
            return $this->maxRating;
        }

        /**
         *
         * @param string $maxRating
         *  The maximum rating allow on your app.
         *
         * @throws \InvalidArgumentException
         * @since 1.0
         */
        public function setMaxRating(string $maxRating) {
            // Default rating authorized by Gravatar service.
            $defaultRatings = array(
                'g',
                'pg',
                'r',
                'x',
            );
            $defaultRatingToLower = strtolower($maxRating);

            // Check if the maxRating is allowed by Gravatar,
            if (in_array($defaultRatingToLower, $defaultRatings) === true) {
                $this->maxRating = $maxRating;
            } else {
                throw new \InvalidArgumentException(
                    'The rating specified is invalid. Use only "g", "pg", "r" or "x" value.'
                );
            }
        }

        /**
         * Indicate if you use the secure uri or not to get the avatar from Gravatar.
         *
         * @return bool
         * @since 1.0
         */
        public function isSecureUri(): bool {
            return $this->secureUri;
        }

        /**
         * Set the boolean to use or not the secure uri.
         *
         * @param bool $secureUri
         *  Set if you would use the secure uri to get the avatar from the service.
         * @since 1.0
         */
        public function setSecureUri(bool $secureUri) {
            $this->secureUri = $secureUri;
        }
    }
