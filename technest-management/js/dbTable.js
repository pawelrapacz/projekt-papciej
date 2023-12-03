import { ConfirmToPHP } from "../../js/Confirm.js";
import { DialogToPHP } from "../../js/Dialog.js";

// REQUEST TYPES
const DELETE_CHECKED = 'DELETE_CHECKED';
const DELETE = 'DELETE';
const EDIT = 'EDIT';
const CREATE_NEW = 'CREATE_NEW';




// table listeners
const table = document.querySelector('.table');
const TABLE_NAME = table.querySelector('._table_name').innerText;
const TABLE_FIELDS = getFieldsNames(); Object.freeze(TABLE_FIELDS);
const rows = table.querySelectorAll('.table-row');

const checkAllBtn = table.querySelector('._check_all');
const checkIndividual = table.querySelectorAll('._check_individual');
const deleteCheckedBtn = table.querySelector('._delete_checked');
const createNewBtn = table.querySelector('._create_new');


rows.forEach(row => {
    const cells = row.querySelectorAll('.expandable');

    cells.forEach(cell => {
        const cellTextBox = cell.firstChild;
        const cellText = cellTextBox.innerText;
        const MAX_CHAR_PER_CELL = 15;
        
        if (cellText.length < MAX_CHAR_PER_CELL) return;

        cellTextBox.innerText = cellText.substring(0, MAX_CHAR_PER_CELL);
        
        const cellHidden = cell.insertBefore(document.createElement('span'), cellTextBox);
        cellHidden.appendChild(document.createTextNode(cellText));
        cellHidden.classList.add('none');

        let expanded = false;
        const cellExpandBtn = cell.appendChild(document.createElement('button'));
        cellExpandBtn.appendChild(document.createTextNode('...'));
        cellExpandBtn.setAttribute('title', 'Rozwiń');
        cellExpandBtn.addEventListener('click', function() {
            if (expanded)
            {
                expanded = false;
                cellExpandBtn.setAttribute('title', 'Rozwiń');
                cellTextBox.innerText = cellText.substring(0, MAX_CHAR_PER_CELL);
                return;
            }
            expanded = true;
            cellExpandBtn.setAttribute('title', 'Zwiń');
            cellTextBox.innerText = cellText;
        });
    });

    const editBtn = row.querySelector('._edit');
    const deleteBtn = row.querySelector('._delete');

    editBtn.addEventListener('click', renderEditBox);
    deleteBtn.addEventListener('click', renderDeleteBox);
});

deleteCheckedBtn.addEventListener('click', function() {
    const checkedRows = [];
    
    for (const checkbox of checkIndividual)
        if (checkbox.checked) checkedRows.push(checkbox.closest('.table-row').id);
    
    if (!checkedRows.length) return;
    
    const confirm = new ConfirmToPHP(`Zaznaczone rekordy (${checkedRows.length}) zostana trwale usunięte, czy chcesz kontynuować?`, 'Tak', 'Nie', 'post', 'request.php');
    confirm.setRequestType(DELETE_CHECKED);
    confirm.addSendToPHPValue('table', TABLE_NAME);
    confirm.addSendToPHPValue('amountToDelete', checkedRows.length);
    
    
    for (let i = 0; i < checkedRows.length; i++)
        confirm.addSendToPHPValue(i, checkedRows[i]);
});

createNewBtn.addEventListener('click', () => {
    const newItemForm = new DialogToPHP('Utwórz nowy:', 'Utwórz', 'Anuluj', 'post', 'request.php');
    
    newItemForm.setRequestType(CREATE_NEW);
    newItemForm.addSendToPHPValue('table', TABLE_NAME);

    for (let i = 0; i < TABLE_FIELDS.length; i++)
        if (i !== 0) newItemForm.addInput('text', TABLE_FIELDS[i], TABLE_FIELDS[i]);
});



checkAllBtn.addEventListener('change', function() {
    if (this.checked === true)
        checkIndividual.forEach(checkRow)
    else
        checkIndividual.forEach(uncheckRow)
});

checkIndividual.forEach(checkbox => {
    // check one row in a table
    checkbox.addEventListener('change', checkboxIndividualHandler);
});



function getFieldsNames()
{
    // usually .table-fields containes a checkbox which isn't a proper field of a table
    const tableFields = Array.from(table.querySelector('.table-fields').children);
    const fieldsNames = [];

    tableFields.forEach(el => {
        if (el.firstChild === null || el.firstChild.nodeType !== Node.TEXT_NODE) return;
        fieldsNames.push(el.firstChild.nodeValue);
    });

    return fieldsNames;
}


function checkRow(checkbox)
{
    checkbox.checked = true;
}

function uncheckRow(checkbox)
{
    checkbox.checked = false;
}

function checkboxIndividualHandler(checkbox)
{
    if (checkAllBtn.checked && !checkbox.checked)
        checkAllBtn.checked = false;
    else if (allRowsChecked())
        checkAllBtn.checked = true;
}

function allRowsChecked()
{
    let checked = true;

    for (let i = 0; i < checkIndividual.length; i++)
    {
        if (!checkIndividual[i].checked)
        {
            checked = false;
            break;
        }
    }

    return checked;
}


function renderEditBox()
{
    const rowCells = this.closest('.table-row').querySelectorAll('.expandable');
    const rowValues = [];

    for (const cell of rowCells) rowValues.push(cell.firstChild.innerText);
    
    const editItemForm = new DialogToPHP('Edytuj dane:', 'Zapisz', 'Anuluj', 'post', 'request.php');
    editItemForm.setRequestType(EDIT);
    editItemForm.addSendToPHPValue('table', TABLE_NAME);

    for (let i = 0; i < rowCells.length; i++)
    {
        if (i === 0 && String(TABLE_FIELDS[i]).toLowerCase().includes('id'))
        {
            editItemForm.addSendToPHPValue('id', rowValues[i]);
            continue;
        }
        editItemForm.addInput('text', TABLE_FIELDS[i], TABLE_FIELDS[i], rowValues[i]);
    }
}

function renderDeleteBox()
{
    const id = this.closest('.table-row').id;
     
    const confirm = new ConfirmToPHP(`Rekord o id ${id} zostanie trwale usunięty, czy chcesz kontynunować?`, 'Tak', 'Nie', 'post', 'request.php');
    confirm.setRequestType(DELETE);
    confirm.addSendToPHPValue('table', TABLE_NAME);
    confirm.addSendToPHPValue('id', id);
}
