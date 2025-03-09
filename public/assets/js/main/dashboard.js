//services
import { downloadLogFile } from '../services/dashboard/download.logfile.js';
import { deleteLog } from '../services/dashboard/deleteLog.logfile.js';
import { logEvent } from '../services/dashboard/logevent.logfile.js';
import { downloadTable } from '../services/dashboard/download.table.js'; 
import { submitMail } from '../services/dashboard/submit.mailform.js'
import { get_dogtable } from '../services/home/get_dogtable.js';
import { insertDog, selectDog, deleteDog, updateDog } from '../services/dashboard/dogCrud.js';
//views
import { appendButtons, appendDelete } from '../view/dashboard/appendelement.view.js';
import { createTableAndMail } from "../view/dashboard/table.view.js";
import { renderResponse } from '../view/dashboard/mailresponse.view.js'
import { downloadLogFileView } from '../view/dashboard/downloadlog.view.js'
import { dogTable } from '../view/dashboard/dogtable.view.js'
import { renderNewDog,  renderStoredDog, renderEditModal} from '../view/dashboard/dogCrud.view.js'
//global variable
import { url } from '../utils/globalVariables.js'

//dog creation

//----------------------------------------------//
//functions
const deleteClick = async (event) => {
  try {
    const id = event.target.parentElement.dataset.id;
    const responseBool = await deleteDog(url, id);
    if (responseBool) {
      const responseObject = await selectDog(url, 'ALL');
      const {result, response} = responseObject;
      renderStoredDog(result, response);
      addDelete();
      addEdit();
    } else {
      throw new Error('dog not deleted');
    }
  } catch (err) {
    console.error(err)
  }
}

const updateClick = async (event) => {
  const id = event.target.parentElement.dataset.id;
  const modal = renderEditModal();

  const addEvent = async (newEvent) => {
    newEvent.preventDefault();
    try {
      const form = new FormData(newEvent.target);
      form.append('id', id);
      const all = await updateDog(url, form);
      if (all.response.status == 200) {
        modal.style.display = 'none';
        console.log(all)
        const responseObject = await selectDog(url, all.result.message);
        const {result, response} = responseObject;
        renderStoredDog(result, response);
        addDelete();
        addEdit()
      } else {
        renderStoredDog(all.result, all.response);
      }
    } catch (err) {
      console.error(err)
    }
  }
  document.querySelectorAll('.update-dog-form').forEach(element => {
    element.replaceWith(element.cloneNode(true));
    document.querySelector('.update-dog-form').addEventListener('submit', addEvent)
  });
}

function addDelete() {
  document.querySelectorAll('.delete-dog').forEach((element) => {
  element.removeEventListener('click', deleteClick)
  element.addEventListener('click', deleteClick)
})
}

function addEdit() {
document.querySelectorAll('.update-dog').forEach((element) => {
  element.removeEventListener('click', updateClick)
  element.addEventListener('click', updateClick)
})
}
//----------------------------------------------//
//event listeners
document.getElementById('insert-dog-form').addEventListener('submit', async (event) => {
  event.preventDefault();
  try {
    const responseObject = await insertDog(event, url);
    const {result, response} = responseObject;
    renderNewDog(result, response);
    addDelete();
    addEdit();
  } catch (err) {
    console.error(err);
  }
})

document.getElementById('read-dogs').addEventListener('click', async (event) => {
  try {
  const data = event.target.dataset;
  const arrayId = data.id
  const responseObject = await selectDog(url, arrayId);
  const {result, response} = responseObject;
  renderStoredDog(result, response);
  addDelete();
  addEdit()
  } catch (err) {
    console.error(err)
  }
})

document.getElementById('clear-dogs').addEventListener('click', () => {
  document.getElementById('doglist').innerHTML = '';
})

//admin dashboard
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
      const table = createTableAndMail(response, result);
      appendDelete(table);
      attachDeleteListener(type, date, url)
    }
  } catch (error) {
    console.error(error)
  }
})

function attachDeleteListener(type, date, url) {
  document.querySelectorAll('.delete-log').forEach( element => {
    element.addEventListener('click', async () => {
      console.log('hello')
      await deleteLog(type, element, url);
      const {result, response} = await downloadTable(type, date, url);
      console.log(response)
      const table = createTableAndMail(response, result);
      console.log(table)
      appendDelete(table);
      attachDeleteListener(type, date, url, response)
    })
  })
}

//log out
window.addEventListener('load', () => {
  if (document.getElementById('log-out-button')) {
    document.getElementById('log-out-button').addEventListener('click', async (event) => {
      const responseObject = await fetch(`${url}authentication/logout/access`, {
        method: 'DELETE'
      })
      
      if (responseObject.status >= 200) {
        const response = await responseObject.json();
        document.cookie.split("; ").forEach(cookie => {
          if (cookie.includes("jwtRefresh=")) {
              document.cookie = "jwtRefresh=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
          }
      });
      
        window.location.href = url;
      }
    
    })
  }

  document.getElementById('toggle-creation').addEventListener('click', (event) => {
    document.querySelectorAll('.dashboard-sections').forEach((element) => {
      element.style.display = 'none'
    })
    document.querySelector('.creation-section').style.display = 'block';
  })

  document.getElementById('toggle-admin').addEventListener('click', (event) => {
    document.querySelectorAll('.dashboard-sections').forEach((element) => {
      element.style.display = 'none'
    })
    document.querySelector('.admin-section').style.display = 'block';
  })
})


































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