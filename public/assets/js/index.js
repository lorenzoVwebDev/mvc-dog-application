import { get_dogtable } from './services/get_dogtable.js';
import { dogTable } from './view/dogtable.view.js'
const server = 'https://apachebackend.lorenzo-viganego.com/mvc-dog-application/public/';
const local = 'http://mvc-dog-application/public/'
const url = local;

document.addEventListener('submit', async (event) => {
  event.preventDefault();
  try {
    const response = await get_dogtable(event, local);
    dogTable(response);
  } catch (err) {
    console.error(err);
  }
})



