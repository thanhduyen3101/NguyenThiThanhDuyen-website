import React from 'react';

// import Slide from '../slide/Slide';
// import CarouselTeacher from '../carousel/CarouselTeacher';

import '../Aboutus/_aboutus.css';
// import '../../../assets/_responsive.css';

import { FaChalkboardTeacher } from 'react-icons/fa';
import TeacherList from '../../component/TeacherList/TeacherList';


function About() {

  return (
    <div>
      <div className='about-pic-top' id='about-scroll'></div>
      <div className='about-title'>
        <h2>Giới thiệu về chúng tôi</h2>
      </div>
      <div className='about'>
        <div className='about-info'>
          <p>Trung tâm được thành lập và bắt đầu tuyển sinh từ năm 2015 
            bởi Cô Lyly Phạm, Giảng viên Tiếng Anh chuyên ngành, 
            trường Đại học Ngoại Ngữ. Trước tình hình ngày một phát 
            triển về quy mô tuyển sinh và chất lượng giảng dạy, LWU 
            vui mừng được nhiều phụ huynh và học viên biết đến đăng ký theo học, 
            chúng tôi vẫn luôn mong muốn được cung cấp phương pháp học và môi 
            trường học hiệu quả tại Đà Nẵng. Ngoài việc chú trọng vào chất 
            lượng giảng dạy – yếu tố tiên quyết được đặt lên hàng đầu tại đây, chúng tôi còn tích cực hợp tác với các đối tác chiến 
            lược như IDP – một trong những đơn vị khảo thí thi IELTS uy tín nhất 
            hiện nay, để đảm bảo mang đến những lợi ích và môi trường rèn luyện, 
            học tập cho học viên của trung tâm. Sự hợp tác 
            này hứa hẹn sẽ đem đến nhiều hoạt động bổ ích, hấp dẫn và tạo môi 
            trường học tập, rèn luyện tiếng anh cho các bạn học sinh, sinh viên 
            tại Đà Nẵng! </p>
          
          <div className='about-founder'>
            <div className='col-6 about-founder-img'>
              {/* img */}
            </div>
            <div className='col-6 about-founder-info'>
              <h3>Người sáng lập</h3>
              <p>Cô Lyly Phạm với kinh nghiệm giảng dạy hơn 7 năm. Cùng 
                 xem qua profile cực khủng của Ms. Lyly nhé:</p>
              <ul>
                <li>
                Giáo viên Sáng lập và Giám Đốc Học Thuật của LWU. 
                Ms. Lyly tốt nghiệp Thạc sĩ chuyên ngành Quản lý Quốc tế của ĐH 
                Southampton Anh Quốc (Top 20 Đại học tại Anh thuộc Russell Group,
                 Top 1% Đại học trên thế giới), loại Xuất sắc (Distinction), tốt 
                 nghiệp Cử nhân Tài Chính và Ngân Hàng Quốc tế của ĐH Ngoại
                  Thương Hà Nội, loại Giỏi. 
                </li>
                <li>Chứng chỉ IELTS Teacher Training Program 2021 cấp bởi 
                  IDP Australia cho kĩ năng Speaking và Writing.</li>
                <li>
                Vinh hạnh nhận Bằng Khen Bộ Ngoại Giao cho những đóng góp  đối 
                với thành công năm APEC 2017 tại Việt Nam (Liaison Officer, 
                phiên dịch tháp tùng đoàn Phu Nhân Tổng Thống Peru).
                </li>
              </ul>
              

            </div>
          </div>
        </div>
        
      </div>
      <div className='about-value'>
        <h3>Tầm nhìn - Sứ mệnh</h3>
        <ul>
          <li>Đào tạo một thế hệ không chỉ có khả năng thích ứng với thế giới đang thay đổi mà còn góp phần thay đổi thế giới.</li>
          <li>Chúng tôi cam kết xây dựng một nền tảng giáo dục sẵn sàng-cho tương lai và gắn chặt với môi trường làm việc hiện đại, cũng như phát triển các giá trị của một công dân địa phương - toàn cầu.</li>
        </ul>
        <div className='about-value-pic'>
          <div className='picture pic-1'></div>
          <div className='picture pic-2'></div>
          <div className='picture pic-3'></div>
        </div>
      </div>
      <div className='about-team'>
        <div className='about-team-title'>
          <h3>Giáo viên giảng dạy</h3>
        </div>
        <TeacherList />
      </div>  
    </div>
  )
}

export default About