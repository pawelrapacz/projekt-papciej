class base_confirm
{
    constructor(text, answ1, answ2, callback) {
        this.callback = callback;
        this.backdrop = document.createElement('div');
        this.box = this.backdrop.appendChild(document.createElement('div'));

        const title = this.box.appendChild(document.createElement('p'));
        title.appendChild(document.createTextNode(text));

        this.btnWrapper = this.box.appendChild(document.createElement('div'))
        this.confirmBtn = this.btnWrapper.appendChild(document.createElement('button'));
        this.cancelBtn = this.btnWrapper.appendChild(document.createElement('button'));
        
        this.backdrop.classList.add('popup-backdrop');
        this.box.setAttribute('id', 'confirmBox');
        this.box.setAttribute('tabindex', '0');
        this.box.classList.add('confirm');
        this.confirmBtn.classList.add('std-btn');
        this.cancelBtn.classList.add('std-btn');
        this.confirmBtn.appendChild(document.createTextNode(answ1));
        this.cancelBtn.appendChild(document.createTextNode(answ2));
        
        this.confirmBtn.addEventListener('click', () => {
            this.yes();
        });
        
        this.cancelBtn.addEventListener('click', () => {
            this.no();
        });
        
        document.body.style.overflowY = 'hidden';
        document.body.appendChild(this.backdrop);
        this.box.focus();
    }

    yes() {
        document.body.style.overflowY = 'scroll';
        this.backdrop.remove();
        
        if (typeof( function(){} ) === typeof( this.callback ))
            this.callback();
    }

    no() {
        document.body.style.overflowY = 'scroll';
        this.backdrop.remove();
    }
}




class confirm_to_php extends base_confirm
{
    constructor(text, answ1, answ2, method, action) {
        super(text, answ1, answ2);

        this.form = this.box.appendChild(document.createElement('form'));

        this.form.setAttribute('method', method);
        this.form.setAttribute('action', action);
        this.form.appendChild(this.btnWrapper);
    }

    addSendToPHPValue(id, value) {
        if (!value)
        {
            this.backdrop.remove();
            throw 'Error [confirm_to_php.addSendToPHPValue()] no input value provided'; 
        }

        const input = this.form.insertBefore(document.createElement('input'), this.btnWrapper);
        
        input.classList.add('none');
        input.setAttribute('type', 'text');
        input.setAttribute('readonly', '');
        input.setAttribute('name', id);
        input.setAttribute('value', value);
    }

    request_type(type) {
        this.addSendToPHPValue('__request_type', type);
    }

    yes()
    {
        this.form.submit();
    }
}