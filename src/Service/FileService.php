<?php 

namespace Rangel\Tcc\Service;
use DateTimeImmutable;
use Exception;

class FileService {

    private readonly string $dirFromRoot;

    public function __construct(string $dirToSave){
        $this->dirFromRoot = ROOT_DIR . $dirToSave . '/';
    }

    public static function generateUID(): string{
        $time = new DateTimeImmutable('');
        $time = $time->format('ymdhisu');

        $randomLongNumber = rand(0, PHP_INT_MAX);

        return $time . $randomLongNumber;
    }

    /**
     * Responsável por salvar um arquivo no servidor
     * @param array $file recebe um array contendo a informação do arquivo enviado: $_FILE['foto']
     * @param string $fileSizeLimit recebe o limite em bytes do arquivo, para não limitar envie um número menor ou igual a 0
     * @param array $validTypes recebe os tipos válidos para salvar, ex: 'image/png'. Caso seja enviado um array vazio, não validará o tipo
     */
    public function save(array $file, string $fileName, int $fileSizeLimit = -1, array $validTypes = []): bool{
        if($fileSizeLimit > 0 && (int)$file['size'] > $fileSizeLimit)
            throw new Exception('O arquivo é muito grande! Tamanho máximo: ' . $fileSizeLimit . ' bytes'); 

        if(!empty($validTypes) && !in_array($file['type'], $validTypes))
            throw new Exception('O tipo do arquivo não é válido! Tipos permitidos: ' . implode(', ', $validTypes));

        return move_uploaded_file($file['tmp_name'], $this->dirFromRoot . $fileName);
    }

    public function remove(string $fileName): bool{
        $path = $this->dirFromRoot . $fileName;
        
        if(file_exists($path)){
            return unlink($path);
        }

        return true;
    }

}