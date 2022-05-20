import React, { useState, useEffect } from "react";
import axios from "axios";
import { apiUrl } from '../../../../context/Constants';
import { ToastContainer, toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
import '../course/_course.css';

const Course = (props) => {
    const [course, setCourse] = useState();

    async function fetchData() {
        await axios.get(`${apiUrl}/student/category/detail/${props.match.params.id}`)
            .then(async (response) => {
                if (response.data.success) {
                    setCourse(response.data.data);
                } else {
                    window.location.href = '/';
                }
            })
            .catch((error) => {
                window.location.href = '/';
            });
    }

    useEffect(() => {
        axios.defaults.headers.common[
            "Authorization"
        ] = `Bearer ${localStorage["token"]}`;
        fetchData();
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
                        <p><h4>Name: </h4> {course.name}</p>
                        <p><h4>Description: </h4> {course.description}</p>
                        <div className="course-date">
                            <p><h4>Start: </h4> {course.start_day}</p>
                            <p><h4>End: </h4> {course.end_day}</p>
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