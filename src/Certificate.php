<?php

namespace Longinus\Apibanking;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Certificate
{
    public function __construct($certificate)
    {
        $this->certificate = $certificate;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPathPublicCertificate(): array|bool
    {
        $pfx = Storage::disk('local')->get($this->certificate);
        $done = openssl_pkcs12_read($pfx, $certs, $this->password);
        if($done){
            if (!file_exists('certificado/')) {
                mkdir('certificado/', 0777, false);
            }else {
                $files = scandir('certificado/');

                foreach ($files as $file) {
                    // Ignora os diretórios pai e atual
                    if ($file != "." && $file != "..") {
                        // Verifica se é um arquivo ou uma pasta
                        if (is_dir('certificado/' . $file)) {
                            // Se for uma pasta, exclui-a recursivamente
                            rmdir('certificado/' . $file);
                        } else {
                            // Se for um arquivo, exclui-o
                            unlink('certificado/' . $file);
                        }
                    }
                }

                // Exclui a pasta principal
                rmdir('certificado/');

                mkdir('certificado/', 0777, false);
            }
            $cert = $certs['cert']; //.pem
            $privateKey = $certs['pkey']; //.key
            $certName = Str::random(5) . '_' . time() . '.cer';
            $publicPath = public_path('certificado/');
            $certPath = $publicPath. $certName;
            file_put_contents($certPath, $cert);
            $keyName = Str::random(5) . '_' . time() . '.key';
            $keyPath = $publicPath. $keyName;
            file_put_contents($keyPath, $privateKey);

            return [$certPath, $keyPath];
        }else{
            return false;
        }
    }

}
