<?php

use function PHPSTORM_META\type;

class Complexe
{
    public float $re;
    public float $im;
    public float $mag;
    public float|null $arg;

    function __construc(float $a, float $b, string $mode='alg'): void
    {
        if ($mode == 'alg'){
            $this->re = $a;
            $this->im = $b;
            $this->update();
        }
        if ($mode == 'pol'){
            $this->mag = $a;
            $this->arg = $b;
            $this->re = $a*cos($b);
            $this->im = $a*sin($b);
        }else{
            throw new Error("Parameters must be either realpart;impart or magnitude/angle");
        }
    }

    function update()
    {
        $this->mag = sqrt($this->re*$this->re + $this->im*$this->im);
        if ($this->mag != 0)
        {
            $this->arg = acos($this->re / $this->im);
            if ($this->im < 0)
            {
                $this->arg = -$this->arg;
            }
        }else{
            $this->arg = null;
        }
    }

    function realpart(): float
    {
        return $this->re;
    }
    function impart(): float
    {
        return $this->im;
    }
    function magnitude(): float
    {
        return $this->mag;
    }
    function magnitude2(): float
    {
        return $this->re*$this->re + $this->im*$this->im;
    }
    function argument(): float|null
    {
        if ($this->arg != null){
            return $this->arg;
        }else{
            return null;
        }
    }

    function add_scalar(float $r): void
    {
        $this->re += $r;
        $this->update();
    }
    function getAdd_scalar(float $r): float
    {
        return $this->re + $r;
    }

    function mult_scalar(float $r): void
    {
        $this->re = $this->re * $r;
        $this->im = $this->im * $r;
        $this->update();
    }
    function getMult_scalar($r): Complexe
    {
        return new Complexe($this->re*$r, $this->im*$r);
    }

    function div_scalar(float $r): void
    {
        if ($r == 0)
        {
            throw new ValueError('Cannot divide by 0!');
        }
        $this->re = $this->re / $r;
        $this->im = $this->im / $r;
        $this->update();
    }
    function getDiv_scalar(float $r): Complexe
    {
        if ($r == 0)
        {
            throw new ValueError('Cannot divide by 0!');
        }
        return new Complexe($this->re/$r, $this->im/$r);
    }

    function conjugate(): void
    {
        $this->im = -$this->im;
        $this->arg = 2*pi() - $this->arg;
    }
    function getConjugate(): Complexe
    {
        return new Complexe($this->re, -$this->im);
    }

    function add(Complexe $z) : void 
    {
        if ($z instanceof Complexe)
        {
            $this->re += $z->re;
            $this->im += $z->im;
            $this->update();
        }else{
            throw new ValueError('Add parameters must be a complexe');
        }
    }
    function getAdd(Complexe $z) : Complexe
    {
        if ($z instanceof Complexe)
        {
            return new Complexe($this->re + $z->re, $this->im + $z->im);
        }else{
            throw new ValueError('Add parameters must be a complexe');
        }
    }

    function sub(Complexe $z) : void 
    {
        if ($z instanceof Complexe)
        {
            $this->re -= $z->re;
            $this->im -= $z->im;
            $this->update();
        }else{
            throw new ValueError('Sub parameters must be a complexe');
        }
    }
    function getSub(Complexe $z) : Complexe
    {
        if ($z instanceof Complexe)
        {
            return new Complexe($this->re - $z->re, $this->im - $z->im);
        }else{
            throw new ValueError('Sub parameters must be a complexe');
        }
    }

    function mult(Complexe $z) : void 
    {
        if ($z instanceof Complexe)
        {
            $re = $this->re;
            $im = $this->im;
            $this->re = $re*$z->re - $im*$z->im;
            $this->im = $im*$z->re + $re*$z->im;
            $this->update();
        }else{
            throw new ValueError('Mult parameters must be a complexe');
        }
    }
    function getMult(Complexe $z) : Complexe
    {
        if ($z instanceof Complexe)
        {
            return new Complexe($this->re*$z->re - $this->im*$z->im, $this->im*$z->re + $this->re*$z->im);
        }else{
            throw new ValueError('Mult parameters must be a complexe');
        }
    }

    function invert() : void 
    {
        if ($this->mag == 0){
            throw new Error("Connot invert 0");
        }else{
            $this->re = $this->re / $this->magnitude2();
            $this->im = $this->im / $this->magnitude2();
            $this->update();
        }
    }
    function getInvert() : Complexe 
    {
        if ($this->mag == 0){
            throw new Error("Connot invert 0");
        }else{
            return new Complexe($this->re / $this->magnitude2(), $this->im / $this->magnitude2());
        }
    }

    function div(Complexe $z): void
    {
        if ($z instanceof Complexe)
        {
            $c = $z->getConjugate();
            $c->mult($this);
            $this->re = $c->re / $z->magnitude2();
            $this->im = $c->im / $z->magnitude2();
            $this->update();
        }else{
            throw new ValueError('Div parameters must be a complexe');
        }
    }
    function getDiv(Complexe $z): Complexe
    {
        if ($z instanceof Complexe)
        {
            $Z = $this->getMult($z->getConjugate());
            return new Complexe($Z->re / $z->magnitude2(), $Z->im / $z->magnitude2());
        }else{
            throw new ValueError('Div parameters must be a complexe');
        }
    }

    function squared(): void
    {
        $re = $this->re;
        $im = $this->im;
        $this->re = $re*$re -$im*$im;
        $this->im = 2*$re*$im;
        $this->update();
    }
    function getSquared(): Complexe
    {
        return new Complexe($this->re*$this->re - $this->im*$this->im, 2*$this->re*$this->im);
    }

    function pow(int $n ): void
    {
        $tau = 2*pi();
        if ($n == 0)
        {
            $this->mag = 1;
        }
        if ($n > 0)
        {
            $this->mag = pow($this->mag, $n); 
        }
        if ($n < 0)
        {
            $this->mag = 1 / pow($this->mag, -$n);
        }
        $this->arg = $this->arg *$n;
        while ($this->arg >= $tau){
            $this->arg -= $tau;
        }
        $this->re = $this->mag*cos($this->arg);
        $this->im = $this->mag*sin($this->arg);
    }
    function getPow(int $n): Complexe
    {
        if ($n == 0){
            $m = 1;
        }
        if ($n > 0)
        {
            $m = pow($this->mag, $n); 
        }
        if ($n < 0)
        {
            $m = 1 / pow($this->mag, -$n);
        }
        $tau = 2*pi();
        $a = $this->arg * $n;
        while ($this->arg >= $tau){
            $this->arg -= $tau;
        }
        return new Complexe($m, $a, $mode='pol');
    }
}