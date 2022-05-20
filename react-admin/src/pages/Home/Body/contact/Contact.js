import React from 'react';
import './_contact.css';

import { ImLocation2 } from 'react-icons/im';
import { BsTelephoneFill } from 'react-icons/bs';
import { MdOutlineEmail } from 'react-icons/md';
import MapComponent from '../../component/Map/MapComponent';
import { HashLink } from 'react-router-hash-link';

function Contact() {

  return (
    <div>
      <div className='contact-pic-top' id='contact-scroll'></div>
      <div className='about-title'>
        <h2>Danh sách các cơ sở</h2>
      </div>
      <div className='contact'>
        <div className='contact-text'>
          <div>
          <ul>
            <li className='contact-text-title'>
              <ImLocation2 className='contact-icons' size={26}/> LWT Hải Châu
            </li>
            <p>Tầng 2 Tòa nhà LWT, 12 Nguyễn Hữu Thọ, quận Hải Châu, Đà Nẵng</p>
            
          </ul>
          <ul className='contact-text-2'>
            <li>
              <BsTelephoneFill className='contact-icons' size={18}/> 0987678965
            </li>
            <li>
              <MdOutlineEmail className='contact-icons' size={22}/> learningwithus@gmail.com
            </li>
          </ul>  
          </div>
          <HashLink to='/#sign-up'><button>Đăng ký ngay</button></HashLink>
        </div>

        <div className='contact-text'>
          <div>
          <ul>
            <li className='contact-text-title'>
              <ImLocation2 className='contact-icons' size={26}/> LWT Thanh Khê
            </li>
            <p>Tầng 5 Tòa nhà KangNam, 55 Điện Biên Phủ, quận Thanh Khê, Đà Nẵng</p>
            
          </ul>
          <ul className='contact-text-2'>
            <li>
              <BsTelephoneFill className='contact-icons' size={18}/> 0987678962
            </li>
            <li>
              <MdOutlineEmail className='contact-icons' size={22}/> learningwithus@gmail.com
            </li>
          </ul>  
          </div>
          <HashLink to='/#sign-up'><button>Đăng ký ngay</button></HashLink>
        </div>

        <div className='contact-text'>
          <div>
          <ul>
            <li className='contact-text-title'>
              <ImLocation2 className='contact-icons' size={26}/> LWT Ngũ Hành Sơn
            </li>
            <p>71 Ngũ Hành Sơn, Đại học Kinh tế, quận Ngũ Hành Sơn, Đà Nẵng</p>
            
          </ul>
          <ul className='contact-text-2'>
            <li>
              <BsTelephoneFill className='contact-icons' size={18}/> 0987678969
            </li>
            <li>
              <MdOutlineEmail className='contact-icons' size={22}/> learningwithus@gmail.com
            </li>
          </ul>  
          </div>
          <HashLink to='/#sign-up'><button>Đăng ký ngay</button></HashLink>
        </div>

        <div className='contact-text'>
          <div>
          <ul>
            <li className='contact-text-title'>
              <ImLocation2 className='contact-icons' size={26}/> LWT Sơn Trà
            </li>
            <p>Tầng 4 Tòa nhà LWT New, 1 Phạm Văn Đồng, quận Sơn Trà, Đà Nẵng</p>
            
          </ul>
          <ul className='contact-text-2'>
            <li>
              <BsTelephoneFill className='contact-icons' size={18}/> 0987678966
            </li>
            <li>
              <MdOutlineEmail className='contact-icons' size={22}/> learningwithus@gmail.com
            </li>
          </ul>  
          </div>
          <HashLink to='/#sign-up'><button>Đăng ký ngay</button></HashLink>
        </div>

        <div className='contact-text'>
          <div>
          <ul>
            <li className='contact-text-title'>
              <ImLocation2 className='contact-icons' size={26}/> LWT Liên Chiểu
            </li>
            <p>440 Tôn Đức Thắng, quận Liên Chiểu, Đà Nẵng</p>
          </ul>
          <ul className='contact-text-2'>
            <li>
              <BsTelephoneFill className='contact-icons' size={18}/> 0987678963
            </li>
            <li>
              <MdOutlineEmail className='contact-icons' size={22}/> learningwithus@gmail.com
            </li>
          </ul>  
          </div>
          <HashLink to='/#sign-up'><button>Đăng ký ngay</button></HashLink>
        </div>
      <MapComponent />  
      </div>
    </div>
  )
}

export default Contact;