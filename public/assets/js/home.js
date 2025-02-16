import { get_dogtable } from './services/home/get_dogtable.js';
import { dogTable } from './view/home/dogtable.view.js'
const server = 'https://apachebackend.lorenzo-viganego.com/mvc-dog-application/public/';
const local = 'http://mvc-dog-application/public/'
const url = server;

document.addEventListener('submit', async (event) => {
  event.preventDefault();
  try {
    const response = await get_dogtable(event, url);
    dogTable(response);
  } catch (err) {
    console.error(err);
  }
})




