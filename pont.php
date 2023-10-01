<?php

declare(strict_types=1);

class Pont
{
    private const SURFACE_TEXT = 'Ce pont mesure %dm';
    
    private float $longueur;
    private float $largeur;
    
    public function setLongueur(float $longueur): void
    {
        if ($longueur < 0) {
            trigger_error(
                'La longueur est trop courte. (min 1)', 
                E_USER_ERROR
            );
        }
        
        $this->longueur = $longueur;
    }
    
    public function getLongueur(): float
    {
        return $this->longueur;
    }
    
    public function setLargeur(float $largeur): void
    {
        if ($largeur < 0) {
            trigger_error(
                'La largeur est trop courte. (min 1)', 
                E_USER_ERROR
            );
        }
        
        $this->largeur = $largeur;
    }
    
    public function getLargeur(): float
    {
        return $this->largeur;
    }
    
    public function getSurface(): float
    {
        return $this->longueur * $this->largeur;
    }
    
    public function printSurface(): void
    {
        echo sprintf(self::SURFACE_TEXT, $this->getSurface());
    }
}

$towerBridge = new Pont;
$towerBridge->setLongueur(286.0);
$towerBridge->setLargeur(15.0);

$towerBridge->printSurface();