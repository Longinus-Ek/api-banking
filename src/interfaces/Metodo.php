<?php

namespace Longinus\Apibanking\interfaces;

interface Metodo
{
    function setMethod($method);

    function setAmbiente($ambiente);

    function setBanking($banking);
}
