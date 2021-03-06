<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/container/v1/cluster_service.proto

namespace Google\Cloud\Container\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Configuration for the addons that can be automatically spun up in the
 * cluster, enabling additional functionality.
 *
 * Generated from protobuf message <code>google.container.v1.AddonsConfig</code>
 */
class AddonsConfig extends \Google\Protobuf\Internal\Message
{
    /**
     * Configuration for the HTTP (L7) load balancing controller addon, which
     * makes it easy to set up HTTP load balancers for services in a cluster.
     *
     * Generated from protobuf field <code>.google.container.v1.HttpLoadBalancing http_load_balancing = 1;</code>
     */
    private $http_load_balancing = null;
    /**
     * Configuration for the horizontal pod autoscaling feature, which
     * increases or decreases the number of replica pods a replication controller
     * has based on the resource usage of the existing pods.
     *
     * Generated from protobuf field <code>.google.container.v1.HorizontalPodAutoscaling horizontal_pod_autoscaling = 2;</code>
     */
    private $horizontal_pod_autoscaling = null;
    /**
     * Configuration for the Kubernetes Dashboard.
     *
     * Generated from protobuf field <code>.google.container.v1.KubernetesDashboard kubernetes_dashboard = 3;</code>
     */
    private $kubernetes_dashboard = null;
    /**
     * Configuration for NetworkPolicy. This only tracks whether the addon
     * is enabled or not on the Master, it does not track whether network policy
     * is enabled for the nodes.
     *
     * Generated from protobuf field <code>.google.container.v1.NetworkPolicyConfig network_policy_config = 4;</code>
     */
    private $network_policy_config = null;

    public function __construct() {
        \GPBMetadata\Google\Container\V1\ClusterService::initOnce();
        parent::__construct();
    }

    /**
     * Configuration for the HTTP (L7) load balancing controller addon, which
     * makes it easy to set up HTTP load balancers for services in a cluster.
     *
     * Generated from protobuf field <code>.google.container.v1.HttpLoadBalancing http_load_balancing = 1;</code>
     * @return \Google\Cloud\Container\V1\HttpLoadBalancing
     */
    public function getHttpLoadBalancing()
    {
        return $this->http_load_balancing;
    }

    /**
     * Configuration for the HTTP (L7) load balancing controller addon, which
     * makes it easy to set up HTTP load balancers for services in a cluster.
     *
     * Generated from protobuf field <code>.google.container.v1.HttpLoadBalancing http_load_balancing = 1;</code>
     * @param \Google\Cloud\Container\V1\HttpLoadBalancing $var
     * @return $this
     */
    public function setHttpLoadBalancing($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Container\V1\HttpLoadBalancing::class);
        $this->http_load_balancing = $var;

        return $this;
    }

    /**
     * Configuration for the horizontal pod autoscaling feature, which
     * increases or decreases the number of replica pods a replication controller
     * has based on the resource usage of the existing pods.
     *
     * Generated from protobuf field <code>.google.container.v1.HorizontalPodAutoscaling horizontal_pod_autoscaling = 2;</code>
     * @return \Google\Cloud\Container\V1\HorizontalPodAutoscaling
     */
    public function getHorizontalPodAutoscaling()
    {
        return $this->horizontal_pod_autoscaling;
    }

    /**
     * Configuration for the horizontal pod autoscaling feature, which
     * increases or decreases the number of replica pods a replication controller
     * has based on the resource usage of the existing pods.
     *
     * Generated from protobuf field <code>.google.container.v1.HorizontalPodAutoscaling horizontal_pod_autoscaling = 2;</code>
     * @param \Google\Cloud\Container\V1\HorizontalPodAutoscaling $var
     * @return $this
     */
    public function setHorizontalPodAutoscaling($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Container\V1\HorizontalPodAutoscaling::class);
        $this->horizontal_pod_autoscaling = $var;

        return $this;
    }

    /**
     * Configuration for the Kubernetes Dashboard.
     *
     * Generated from protobuf field <code>.google.container.v1.KubernetesDashboard kubernetes_dashboard = 3;</code>
     * @return \Google\Cloud\Container\V1\KubernetesDashboard
     */
    public function getKubernetesDashboard()
    {
        return $this->kubernetes_dashboard;
    }

    /**
     * Configuration for the Kubernetes Dashboard.
     *
     * Generated from protobuf field <code>.google.container.v1.KubernetesDashboard kubernetes_dashboard = 3;</code>
     * @param \Google\Cloud\Container\V1\KubernetesDashboard $var
     * @return $this
     */
    public function setKubernetesDashboard($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Container\V1\KubernetesDashboard::class);
        $this->kubernetes_dashboard = $var;

        return $this;
    }

    /**
     * Configuration for NetworkPolicy. This only tracks whether the addon
     * is enabled or not on the Master, it does not track whether network policy
     * is enabled for the nodes.
     *
     * Generated from protobuf field <code>.google.container.v1.NetworkPolicyConfig network_policy_config = 4;</code>
     * @return \Google\Cloud\Container\V1\NetworkPolicyConfig
     */
    public function getNetworkPolicyConfig()
    {
        return $this->network_policy_config;
    }

    /**
     * Configuration for NetworkPolicy. This only tracks whether the addon
     * is enabled or not on the Master, it does not track whether network policy
     * is enabled for the nodes.
     *
     * Generated from protobuf field <code>.google.container.v1.NetworkPolicyConfig network_policy_config = 4;</code>
     * @param \Google\Cloud\Container\V1\NetworkPolicyConfig $var
     * @return $this
     */
    public function setNetworkPolicyConfig($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Container\V1\NetworkPolicyConfig::class);
        $this->network_policy_config = $var;

        return $this;
    }

}

