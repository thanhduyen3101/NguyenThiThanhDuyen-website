import React, { useState, useEffect } from "react";
import CountUp from 'react-countup';
import axios from "axios";
import { apiUrl } from '../../../../context/Constants'

import '../Intro/_intro.css';

import SignupForm from '../../component/Signup/Signup';
import { HashLink } from 'react-router-hash-link';
import SlideShow from "../../component/Slide/SlideShow";

function Intro() {
  const [program, setProgram] = useState();

  async function fetchData() {
    const response = await axios.get(`${apiUrl}/student/category/list`);
    setProgram(response.data.data);
  }

  useEffect(() => {
    fetchData();
  }, []);
  
  return (
    <div className='home'>
      <div id='banner'></div>
      <div className='banner-text'>
          <h1>learning with us</h1>
          <p>Trung tâm đào tạo tiếng Anh</p>
            <HashLink to='/#sign-up'>
              <button>
                Đăng kí ngay
              </button>
            </HashLink>
      </div>
      <div id='achieved'>
        <div className='title'>
          <h2>Trung tâm đào tạo tiếng Anh</h2>
          <p>Ngoài việc chú trọng vào chất lượng giảng dạy – yếu tố tiên 
            quyết được đặt lên hàng đầu tại đây, chúng tôi 
            còn tích cực hợp tác với các đối tác chiến lược như IDP – 
            một trong những đơn vị khảo thí thi IELTS uy tín nhất hiện 
            nay, để đảm bảo mang đến những lợi ích và môi trường rèn luyện,
             học tập cho học viên của trung tâm.</p>
        </div>
        <div className='achieved-data'>
          <div className='data-box'>
            <div className='data-count'><CountUp end={8}/></div>
            <p>Giáo viên</p>
          </div>
          <div className='data-box'>
            <div className='data-count'><CountUp end={9500}/></div>
            <p>Học viên đã học</p>
          </div>
          <div className='data-box'>
            <div className='data-count'><CountUp end={7}/></div>
            <p>Năm kinh nghiệm</p>
          </div>
          <div className='data-box'>
            <div className='data-count'><CountUp end={5}/></div>
            <p>Cơ sở</p>
          </div>
        </div>
      </div>
      <div className="slide-show">
        <SlideShow />
      </div>
      <div id='program'>
        <div>
          <div className='title' style={{ marginBottom: "50px" }}>
              <h2>Chương trình đạo tạo phù hợp với mọi đối tượng</h2>
          </div>
        <div className='program-name' id='list-program'>
          {program && program.map((datacourse, index) => (
            <div className='program-card' key={index}>
              <img 
                src={datacourse.image}
                alt={datacourse.name}
              />
              <div className='overlay'>
                <div className='program-text'>
                  <h4>{datacourse.name}</h4>
                  {/* <p>{datacourse.description}</p> */}
                  <div>
                      <HashLink to={'course/detail/'+datacourse.course_id}>
                        <button className='btn-more program-btn'>
                            Chi tiết
                        </button>
                      </HashLink>
                  </div>
                </div>
              </div>
            </div>
          ))}
        </div>
        </div>
        
      </div>
      <div id='signup'>
            <SignupForm />
      </div>
    </div>
  )
}

export default Intro