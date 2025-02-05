import { get_dogtable } from './services/get_dogtable.js';
import { dogTable } from './view/dogtable.view.js'


document.addEventListener('submit', async (event) => {
  event.preventDefault();
  try {
    const formData = new FormData(event.target);
    const response = await get_dogtable(formData);

    if (response.status >= 200 && response.status < 400) {
      let dogArray = await response.text();
      dogTable(dogArray);
      
    } else if (response.status >= 400 && response.status < 500) {
      throw new Error('Bad Request');
    } else if (response.status >= 500) {
      throw new Error('Server Error')
    }
  } catch (err) {
    console.error(err);
  }
})



