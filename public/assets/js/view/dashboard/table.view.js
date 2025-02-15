export function createTableAndMail(result) {
  if (document.querySelector('.table-section')) {
    document.querySelector('.table-section').innerHTML = '';
  }
  let table = document.querySelector('.table-section')
  let div = document.createElement('div');
  let mailFormDiv = document.createElement('div');
  mailFormDiv.classList.add('mail-form-container');
  div.classList.add('table-container')
  div.innerHTML = result;
  table.append(div);
  return table
}

