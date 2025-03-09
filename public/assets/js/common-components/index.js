import GitRepositoryHeader from './GitRepositoryHeader/GitRepositoryHeader.js'
import Header from './Header/Header.js'
import Footer from './Footer/Footer.js'
import Modal from './Modals/modal.js'
import EditModal from './Modals/edit/edit_dog.modal.js'

document.querySelector('.git-header-section').innerHTML = GitRepositoryHeader;
document.querySelector('.main-header').innerHTML = Header;
document.querySelector('.modal-container').innerHTML = Modal;
document.querySelector('.footer-section').innerHTML = Footer;
document.querySelector('.edit-modal-container').innerHTML = EditModal;

if (document.cookie.split("; ").find(element => {
  return element.includes("jwtRefresh")
})) {
  document.getElementById('left-side-header').style.display = 'none';
  document.getElementById('left-side-header-log-out').style.display = 'block';
} else {
  document.getElementById('left-side-header').style.display = 'block';
  document.getElementById('left-side-header-log-out').style.display = 'none';
}

function getXMLHttp() {
  let xmlHttp;
  
  try {
    xmlHttp = new XMLHttpRequest();
  } catch (e) {
    try {
      xmlHttp = new ActiveXObject('Msxml2.XMLHTTP');
    } catch (e) {
      try {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
      } catch (e) {
        alert("Your browser does not support AJAX. Please update it.");
        return null;
      }
    }
  }

  return xmlHttp;
}

function AjaxRequest(url) {
  return new Promise((resolve, reject) => {
    let xmlHttp = getXMLHttp();
    if (!xmlHttp) {
      reject("XMLHttpRequest is not supported.");
      return;
    }

    xmlHttp.onreadystatechange = () => {
      if (xmlHttp.readyState === 4) {
        if (xmlHttp.status === 200) {
          resolve(xmlHttp.responseText);
        } else {
          reject(`Error: ${xmlHttp.status} ${xmlHttp.statusText}`);
        }
      }
    };

    xmlHttp.open('GET', url, true);
    xmlHttp.send(null);
  });
}

async function attach() {
  const response = await AjaxRequest(`${url}dog/getbreeds?type=selectbox`).then(response => {
    return response
  })

  document.getElementById('AjaxResponseModal').innerHTML =response
}

attach()


