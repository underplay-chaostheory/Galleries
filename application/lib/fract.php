<?php
include('math.php');

class Fraction
{
    public int $num;
    public int $den;

    function __construct(int $num, int $den) :void
    {
        if ($den == 0){
            throw new ValueError('Den must different than 0');
        }
        $this->num = $num;
        $this->den = $den;
        $this->simplify();
    }

    function simplify(): void
    {
        if ($this->num == 0){
            $this->den = 1;
        }else{
            $f_num = factors($this->num);
            $f_den = factors($this->den);
            foreach ($f_num as $i => $num){
                foreach ($f_den as $j => $den){
                    if ($num == $den){
                        unset($f_num[$i]);
                        unset($f_den[$j]);
                    }
                }
            }
            $f_num = array_values($f_num);
            $f_den = array_values($f_den);
            $this->num = 1;
            $this->den = 1;
            foreach ($f_num as $val){
                $this->num *= $val;
            }
            foreach ($f_den as $val){
                $this->den *= $val;
            }
        }
    }
    
    function add_int(int $n): void
    {
        $this->num += $n * $this->den;
        $this->simplify();
    }
    function getAdd_int(int $n): Fraction
    {
        return new Fraction($this->num + $n * $this->den, $this->den);
    }

    function mult_int(int $n): void
    {
        if ($this->den % $n == 0){
            $this->den = intdiv($this->den, $n);
        }else{
            $this->num = $this->num*$n;
        }
    }
    function getMult_int(int $n): Fraction
    {
        if ($this->den % $n == 0){
            return new Fraction($this->num, intdiv($this->den, $n));
        }else{
            return new Fraction($this->num*$n, $this->den);
        }
    }

    function div_int(int $n): void
    {
        if ($this->num % $n == 0){
            $this->num = intdiv($this->num, $n);
        }else{
            $this->den = $this->den*$n;
        }
    }
    function getDiv_int(int $n): Fraction
    {
        if ($this->num % $n == 0){
            return new Fraction(intdiv($this->num, $n), $this->den);
        }else{
            return new Fraction($this->num, $this->den*$n);
        }
    }

    function invert(): void
    {
        $temp = $this->den;
        $this->den = $this->num;
        $this->num = $temp;
    }
    function getInvert(): Fraction
    {
        return new Fraction($this->den, $this->num);
    }

    function opposite(): void
    {
        $this->num = - $this->num;
    }
    function getOpposite(): Fraction
    {
        return new Fraction(-$this->num, $this->den);
    }

    function square(): void
    {
        $this->num = $this->num*$this->num;
        $this->den = $this->den*$this->den;
    }
    function getSquare() : Fraction
    {
        return new Fraction($this->num*$this->num, $this->den*$this->den);
    }

    function pow(int $n): void
    {
        $this->num = pow($this->num, $n);
        $this->den = pow($this->den, $n);
    }
    function getPow(int $n): Fraction
    {
        return new Fraction(pow($this->num, $n), pow($this->den, $n));
    }

    function add(Fraction $q): void
    {
        $this->num = $this->num*$q->den + $this->den*$q->num;
        $this->den = $this->den*$q->den;
        $this->simplify();
    }
    function getAdd(Fraction $q) : Fraction
    {
        return new Fraction($this->num*$q->den + $this->den*$q->num, $this->den*$q->den);
    }

    function sub(Fraction $q): void
    {
        $this->num = $this->num*$q->den - $this->den*$q->num;
        $this->den = $this->den*$q->den;
        $this->simplify();
    }
    function getSub(Fraction $q) : Fraction
    {
        return new Fraction($this->num*$q->den - $this->den*$q->num, $this->den*$q->den);
    }

    function mult(Fraction $q) : void
    {
        $this->num = $this->num*$q->num;
        $this->den = $this->den*$q->den;
        $this->simplify();
    }
    function getMult(Fraction $q): Fraction
    {
        return new Fraction($this->num*$q->num, $this->den*$q->den);
    }

    function div(Fraction $q): void
    {
        $this->num = $this->num*$q->den;
        $this->den = $this->den*$q->num;
        $this->simplify();
    }
    function getDiv(Fraction $q) : Fraction
    {
       return new Fraction($this->num*$q->den, $this->den*$q->num); 
    }
}