import React, { useState, useEffect } from "react";
import axios from "axios";
import { apiUrl } from '../../../../context/Constants';
import { ToastContainer, toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
import '../course/_course.css';
import ProductItem from "../../../../components/productItem";

const Course = (props) => {
    const [course, setCourse] = useState();
    const [score, setScore] = useState();
    const [products, setProducts] = useState();
    const [value, setValue] = useState(false);
    const [pagi, setPagi] = useState(1);

  const [kpilist, setKpilist] = useState([]);


    async function fetchData() {
        await axios.get(`${apiUrl}/student/category/detail/${props.match.params.id}`)
            .then(async (response) => {
                if (response.data.success) {
                    setCourse(response.data.data);
                } else {
                    // window.location.href = '/';
                }
            })
            .catch((error) => {
                // window.location.href = '/';
            });
            // await axios.get(`${apiUrl}/user/kpi`)
            // .then(async (response) => {
            //     if (response.data.success) {
            //         console.log(response.data.data);
            //     } else {
            //         window.location.href = '/';
            //     }
            // })
            // .catch((error) => {
            //     window.location.href = '/';
            // });
    }
    async function fetchLessonData() {
        axios.defaults.headers.common[
          "Authorization"
        ] = `Bearer ${localStorage["token"]}`;
        const response = await axios.get(`${apiUrl}/product/list/`+props.match.params.id);
        setProducts(response.data.data);
    
      }
    async function fetchKPIData() {
            await axios.get(`${apiUrl}/user/kpi`)
            .then(async (response) => {
                
                if (response.data.success) {
                    setScore(response.data.data);
                     
                } else {
                    
                    // window.location.href = '/';
                }
            })
            .catch((error) => {
                
               
                // window.location.href = '/';
            });
    }

    // async function fetchData() {
    //     axios.defaults.headers.common[
    //       "Authorization"
    //     ] = `Bearer ${localStorage["token"]}`;
    //     const response = await axios.get(`${apiUrl}/product/list/`+ props.match.params.id);
    //     setProducts(response.data.data);
    //     setPagination({
    //       ...pagination,
    //       ["_totalRows"]: response.data.data ? response.data.data.length : 0,
    //     });
    //     setValue(false);
    //   }

    useEffect(() => {
        axios.defaults.headers.common[
            "Authorization"
        ] = `Bearer ${localStorage["token"]}`;
        fetchData();
        fetchKPIData();
        fetchLessonData();
    }, []);
    async function handleClick(id) {
        toast.dismiss();
        await axios.post(`${apiUrl}/user/order/create`,
            {
                course_id: id,
            })
            .then(async (response) => {
                if (response.data.success) {
                    toast(response.data.message);
                    setTimeout(() => {
                        window.location.href = '/';
                    }, 2000);
                } else {
                    toast(response.data.message);
                }
            })
            .catch((error) => {
                if (error.response) {
                    toast(error.response.data.message);
                } else {
                    toast("Error");
                }
            });
    }

    // const renderHead = (item, index) => <th key={index}>{item}</th>;

    // const renderBody = (item, index) => {
    //     return (
    //       <tr key={index}>
    //         <td>{item.id}</td>
    //         <td style={{ textAlign: "left" }}>{item.name}</td>
    //         <td>{item.test_1}</td>
    //         <td>{item.test_2}</td>
    //         <td>{item.total}</td>
    //       </tr>
    //     );
    //   };

    return (
        <div>
        {course && (
          <div className="course-title">{course.name}</div>   
        )}   
        <div style={{ marginTop: "20px", minHeight: "500px", marginBottom: "100px", marginRight: "50px", marginLeft: "50px" }}>
            
            {course && (
                <div className="course-pic">
                    <div>
                        <img
                            src={course.image}
                            alt={course.name}
                        />
                    </div>
                    <div className="course-info" style={{paddingLeft: "40px"}}>
                        <p>{course.description}</p>
                        <div className="course-date">
                            <p><h4>Ngày bắt đầu: </h4> {course.start_day}</p>
                            <p><h4>Ngày bắt đầu: </h4> {course.end_day}</p>
                        </div>
                    </div>
                </div>
            )}
            {course && !course.order_id && (
                <div id='contact-scroll' style={{ marginTop: "50px", marginBottom: "50px", marginLeft: "600px" }}>
                    <button
                        className="btn-register"
                        type="button"
                        onClick={() => handleClick(props.match.params.id)}
                    >
                        Đăng ký khóa học
                    </button>
                </div>
            )}
            {course && course.status=="STT4" && (
            <div>
                <div id='contact-scroll' style={{ marginTop: "50px", marginBottom: "50px", marginLeft: "600px" }}>
                    <button
                        className="btn-stt4"
                        type="button"
                        onClick={() => handleClick(props.match.params.id)}
                    >
                        Đăng ký khóa học thành công
                    </button>
                </div>
                <div>

               
                <div>
                    <div className="card">
               
                    { score && score.salesman && ( 
                    <div> 
                        <table style={{ border: "1px solid gray" }}>
                            <tr style={{ border: "1px solid gray" }}>
                                <th>Tên</th>
                                <th>Điểm bài 1</th>
                                <th>Điểm bài 2</th>
                                <th>Tổng cộng</th>
                            </tr>
                            <tr>
                                <td>{score.salesman}</td>
                                <td>{score[0].test_1}</td>
                                <td>{score[0].test_2}</td>
                                <td>{score[0].total}</td>
                            </tr>
                        </table>
                        {/* <h3>Điểm</h3> */}
                    </div>
                    )}
                    
                    </div>
                </div>
                <div className="card">
                    <h3>Danh sách bài giảng</h3>
                    {!products ? (
                        <div className="w-100 text-center">
                            <div className="spinner-border text-dark" role="status"></div>
                        </div>
                 ) : null}
                    <div className="product-panel">
                    {products
                        ?.slice(0)
                        .map((item, index) => {
                            return (
                                <ProductItem
                                    key={index}
                                    id={item.id}
                                    img={item.image}
                                    name={item.title}
                                    content={item.content}
                                    course_name={item.course_name}
                                    setValue={setValue}
                                    showAction={true}
                            
                                />
                            );
                    })}
                    </div>    
                </div>    
                </div>
            </div>
            )}
            {course && course.status=="STT3" && (
                <>
                <div id='contact-scroll' style={{ marginTop: "50px", marginBottom: "50px", marginLeft: "600px" }}>
                    <button
                        className="btn-stt3"
                        type="button"
                        onClick={() => handleClick(props.match.params.id)}
                    >
                        Đăng ký khóa học không thành công
                    </button>
                </div>
                </>
            )}
            {course && course.status=="STT2" && (
                <div id='contact-scroll' style={{ marginTop: "50px", marginBottom: "50px", marginLeft: "600px" }}>
                    <button
                        className="btn-stt2"
                        type="button"
                        onClick={() => handleClick(props.match.params.id)}
                    >
                        Chờ xét duyệt từ quản trị viên
                    </button>
                </div>
            )}
            <ToastContainer
                position="top-right"
                autoClose={3000}
                hideProgressBar={false}
                newestOnTop={false}
                closeOnClick
                rtl={false}
                pauseOnFocusLoss
                draggable
                pauseOnHover
            />
            <ToastContainer />
        </div>
        
        </div>
    )
}

export default Course