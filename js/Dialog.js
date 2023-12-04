export class BaseDialog {
    constructor(text, answ1, answ2, callback) {
        this.inputs = [];
        this.callback = callback;
        this.backdrop = document.createElement('div');
        this.box = this.backdrop.appendChild(document.createElement('div'));
        this.form = this.box.appendChild(document.createElement('form'));
        const title = this.form.appendChild(document.createElement('p'));

        this.btnWrapper = this.form.appendChild(document.createElement('div'));
        this.confirmBtn = this.btnWrapper.appendChild(document.createElement('button'));
        this.cancelBtn = this.btnWrapper.appendChild(document.createElement('button'));

        this.backdrop.classList.add('popup-backdrop');
        this.box.setAttribute('id', 'dialogBox');
        this.box.setAttribute('tabindex', '0');
        this.box.classList.add('confirm');
        this.box.classList.add('dialog');

        title.appendChild(document.createTextNode(text));
        
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

    addInput(type, id, name, defaultValue) {
        const label = this.form.insertBefore(document.createElement('label'), this.btnWrapper);
        label.appendChild(document.createTextNode(name));
        label.appendChild(document.createElement('br'));
        const input = label.appendChild(document.createElement('input'));
        this.inputs.push(input);
        
        input.classList.add('std-input');
        input.classList.add('base_dialog_input');
        input.setAttribute('type', type);
        input.setAttribute('id', id);
        input.setAttribute('name', id);
        // input.setAttribute('placeholder', name);
        
        if (defaultValue)
            input.value = defaultValue;
    }

    addTextArea(id, name, defaultValue) {
        const label = this.form.insertBefore(document.createElement('label'), this.btnWrapper);
        label.appendChild(document.createTextNode(name));
        label.appendChild(document.createElement('br'));
        const textarea = label.appendChild(document.createElement('textarea'));
        this.inputs.push(textarea);
        
        textarea.classList.add('std-textarea');
        textarea.classList.add('base_dialog_textarea');
        textarea.setAttribute('id', id);
        textarea.setAttribute('name', id);
        // textarea.setAttribute('placeholder', name);

        if (defaultValue)
            textarea.value = defaultValue;
    }

    yes() {
        document.body.style.overflowY = 'scroll';
        this.backdrop.remove();
        if (typeof this.callback === 'function')
        {
            const inputValues = {};
            this.inputs.forEach((el) => {
                inputValues[el.id] = el.value;
            });
            console.table(inputValues);
            this.callback(inputValues);
        }
    }
    
    no() {
        document.body.style.overflowY = 'scroll';
        this.backdrop.remove();
    }
}




export class DialogToPHP extends BaseDialog
{
    constructor(text, answ1, answ2, method, action) {
        super(text, answ1, answ2);

        this.form.setAttribute('method', method);
        this.form.setAttribute('action', action);
    }

    addSendToPHPValue(id, value) {
        if (!value)
        {
            this.backdrop.remove();
            throw 'Error [DialogToPHP.addSendToPHPValue()] no input value provided'; 
        }

        const input = this.form.insertBefore(document.createElement('input'), this.btnWrapper);
        
        input.classList.add('none');
        input.setAttribute('type', 'text');
        input.setAttribute('readonly', '');
        input.setAttribute('name', id);
        input.setAttribute('value', value);
    }

    setRequestType(type) {
        this.addSendToPHPValue('requestType', type);
    }

    yes() {
        this.form.submit();
    }
}