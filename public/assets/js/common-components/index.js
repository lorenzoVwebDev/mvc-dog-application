import GitRepositoryHeader from './GitRepositoryHeader/GitRepositoryHeader.js'
import Header from './Header/Header.js'
import Footer from './Footer/Footer.js'
import Modal from './Modals/modal.js'

document.querySelector('.git-header-section').innerHTML = GitRepositoryHeader;
document.querySelector('.main-header').innerHTML = Header;
document.querySelector('.modal-container').innerHTML = Modal;
document.querySelector('.footer-section').innerHTML = Footer;
