import { get_dogtable } from './services/home/get_dogtable.js';
import { dogTable } from './view/home/dogtable.view.js'
import { url } from './utils/globalVariables.js'

document.addEventListener('submit', async (event) => {
  event.preventDefault();
  try {
    const response = await get_dogtable(event, url);
    dogTable(response);
  } catch (err) {
    console.error(err);
  }
})




