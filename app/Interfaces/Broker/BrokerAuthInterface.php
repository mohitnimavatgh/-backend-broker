<?php

namespace App\Interfaces\Broker;


interface BrokerAuthInterface {

    public function brokerRigster($request);
    public function brokerVerification($request);
    public function brokerDetails($request);
    public function brokerGetLoginPin($request);
    public function brokerCertificatedDetailsForWork($request);
    public function brokerlogin($request);
}