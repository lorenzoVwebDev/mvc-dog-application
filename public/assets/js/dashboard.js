import { downloadLogFile } from './services/dashboard/download.logfile.js';
import { deleteLog } from './services/dashboard/deleteLog.logfile.js';
import { logEvent } from './services/dashboard/logevent.logfile.js';
import { downloadTable } from './services/dashboard/download.table.js'; 
import { submitMail } from './services/dashboard/submit.mailform.js'
import { appendButtons, appendDelete } from './view/dashboard/appendelement.view.js';
import { createTableAndMail } from "./view/dashboard/table.view.js";
import { renderResponse } from './view/dashboard/mailresponse.view.js'
import { downloadLogFileView } from './view/dashboard/downloadlog.view.js'
const server = 'https://apachebackend.lorenzo-viganego.com/mvc-dog-application/public/';
const local = 'http://mvc-dog-application/public/'
const url = server;

if (document.getElementById('mail-form')) {
  document.getElementById('mail-form').addEventListener('submit', async event => {
    try {
      const responseObject = await submitMail(event, url);
      const { response, result } = responseObject;
      renderResponse(response, result);
    } catch (error) {
      console.log(error)
    }
  })
}

document.getElementById('log-form').addEventListener('submit', async (event) => {
  event.preventDefault();
  try {
    const type = event.target[0].value;  
    const date = event.target[1].value;  
    if (event.submitter.value === 'download') {
      const resultObject = await downloadLogFile(type, date, url);
      const {response, result} = resultObject;
      downloadLogFileView(response, result, type);
    } else if (event.submitter.value === 'show-table') {
      const { response, result} = await downloadTable(type, date, url);
      console.log(response)
      const table = createTableAndMail(response, result);
      appendDelete(table);
      attachDeleteListener(type, url)
    }
  } catch (error) {
    console.error(error)
  }
})

function attachDeleteListener(type, url) {
  document.querySelectorAll('.delete-log').forEach( element => {
    element.addEventListener('click', async () => {
      await deleteLog(type, element, url);
      const result = await downloadTable(type, url);
      const table = createTableAndMail(result);
      appendDelete(table);
      attachDeleteListener(type, url)
    })
  })
}
































/* document.querySelectorAll('.log-form').forEach(element => {
  element.addEventListener('submit', async (event) => {
    event.preventDefault();
    try {
      const resultObject = await logEvent(event, url);
      const { result, type } = resultObject;
      const displayBool = appendButtons(result);
      if (!displayBool) throw new Error("Error 404");
        document.querySelector(`.${type}-download-button`).addEventListener('click', async (event) => {
        downloadLogFile(type, url) 
      })

      document.querySelector(`.${type}-table-button`).addEventListener('click', async (event) => {
        const result = await downloadTable(type, url);
        const table = createTableAndMail(result);
        appendDelete(table);
        attachDeleteListener(type, url)
      })
    } catch (err) {
      console.error(err)
    }
  })
})
//recursive function that call itself each time
function attachDeleteListener(type, url) {
  document.querySelectorAll('.delete-log').forEach( element => {
    element.addEventListener('click', async () => {
      await deleteLog(type, element, url);
      const result = await downloadTable(type, url);
      const table = createTableAndMail(result);
      appendDelete(table);
      attachDeleteListener(type, url)
    })
  })
} */