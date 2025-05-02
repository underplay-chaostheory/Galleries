class Complexe {
    constructor(a,b,type){
        switch (type){
            case "alg":
                this._re = a;
                this._im = b;
                this.updatepol();
            case "pol":
                this._mod = a;
                this._arg = b;
                this.updatealg();
            default:
                this._re = a;
                this._im = b;
                this.updatepol();
        }
    }

    updatepol(){
        if (this._re == 0 && this._im == 0){
            this._mod = 0;
            this._arg = 0;
        } else if (this._re == 0){
            this._mod = Math.abs(this._im);
            if (this._im >= 0){
                this._arg = Math.PI / 2;
            } else {
                this._arg = - Math.PI / 2;
            }
        } else {
            this._mod = Math.sqrt(this._re**2 + this._im**2);
            this._arg = Math.tan(this._im/this._re);
        }
    }

    updatealg(){
        this._re = this._mod * Math.cos(this._arg);
        this._re = this._mod * Math.sin(this._arg);
    }

    get re(){
        return this._re;
    }
    set re(x){
        this._re = x;
        this.updatepol();
    }
    get im(){
        return this._im;
    }
    set im(x){
        this._im = x;
        this.updatepol();
    }
    get module(){
        return this._mod;
    }
    set module(x){
        this._mod = x;
        this.updatealg();
    }
    get arg(){
        return this._arg;
    }
    set arg(x){
        while (x >= 2 * Math.PI){
            x -= 2 * Math.PI;
        }
        this.mod = x;
        this.updatealg();
    }

    copy(){
        return new Complexe(this._re, this._im);
    }

    add(z){
        this._re += z.re;
        this._im += z.im;
        this.updatepol();
    }
    sub(z){
        this._re -= z.re;
        this._im -= z.im;
        this.updatepol();
    }
    mult(z){
        let x = this._re * z.re - this._im * z.im;
        let y = this._re * z.im + this._im * z.re;
        this._re = x;
        this._im = y;
        this.updatepol();
    }
    div(z){
        if(z.re == 0 && z.im == 0){
            throw new Error("Cannot divide by zero")
        }else{
            let x = (this._re * z.re + this._im * z.im)/(z.re**2 + z.im**2);
            let y = (this._im * z.re - this._re * z.im)/(z.re**2 + z.im**2);
            this._re = x;
            this._im = y;
        }
        this.updatepol();
    }
    inverse(){
        this._im = - this._im / (this.mod ** 2);
        this._re = this._re / (this.mod ** 2);
        this.updatepol();
    }
    power(n){
        this._mod = this._mod ** n;
        this._arg *= n;
        while (x >= 2 * Math.PI){
            x -= 2 * Math.PI;
        }
        this.updatealg();
    }

    oppose(){
        this._re = - this._re;
        this._im = - this._im;
        this.updatepol();
    }

    conjugue(){
        this._im = - this._im;
        this.updatepol();
    }

    affiche(){
        return (this._re).toFixed(3) + " + i" + this._im.toFixed(3);
    }
}