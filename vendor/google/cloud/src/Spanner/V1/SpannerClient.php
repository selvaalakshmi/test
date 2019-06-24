<?php
/*
 * Copyright 2017, Google LLC All rights reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/*
 * GENERATED CODE WARNING
 * This file was generated from the file
 * https://github.com/google/googleapis/blob/master/google/spanner/v1/spanner.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * EXPERIMENTAL: this client library class has not yet been declared GA (1.0). This means that
 * even though we intent the surface to be stable, we may make backwards incompatible changes
 * if necessary.
 *
 * @experimental
 */

namespace Google\Cloud\Spanner\V1;

use Google\Cloud\Spanner\V1\Gapic\SpannerGapicClient;
use Google\ApiCore\GrpcCredentialsHelper;
use Google\Cloud\Spanner\V1\SpannerGrpcClient;

/**
 * {@inheritdoc}
 */
class SpannerClient extends SpannerGapicClient
{
    /**
     * Returns the underlying stub.
     *
     * @access private
     * @return SpannerGrpcClient
     * @experimental
     */
    public function getStub()
    {
        return $this->spannerStub;
    }

    /**
     * Returns the underlying gRPC credentials helper.
     *
     * @access private
     * @return GrpcCredentialsHelper
     * @experimental
     */
    public function getCredentialsHelper()
    {
        return $this->grpcCredentialsHelper;
    }
}
