import React, { useEffect, useState } from "react";

import "./modal.css";

import upload from "../../assets/images/upload1.jpg";
import axios from "axios";
import { apiUrl } from "../../context/Constants";

import { ToastContainer, toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";

function AddcateModal({ setOpenModal, setValue }) {
  const [name, setName] = useState('');
  const [max, setMax] = useState(0);
  const [start, setStart] = useState('');
  const [end, setEnd] = useState('');
  const [desc, setDesc] = useState('');
  const [image, setImage] = useState('');
  const [idTeacher, setIdTeacher] = useState('');
  const [listTeacher, setListTeacher] = useState();
  const [imageprev, setImageprev] = useState(upload);

  const changeImage = (event) => {
    setImage("");
    var file = event.target.files[0];
    setImage(file);
    var reader = new FileReader();
    reader.readAsDataURL(file);

    reader.onloadend = function (e) {
      setImageprev(reader.result);
    }.bind(this);
  };

  const handleOnclick = async () => {
    const formData = new FormData();
    formData.append("name", name);
    formData.append("maximum_student", max);
    formData.append("start_day", start);
    formData.append("end_day", end);
    formData.append("description", desc);
    formData.append("id_teacher", idTeacher);
    formData.append("image", image ? image : "");

    const data = await axios
      .post(`${apiUrl}/admin/category/create`, formData)
      .then((response) => {
        toast.dismiss();
        if (response.data.success) {
          setValue(true);
          toast(response.data.message);
          setTimeout(() => {
            setOpenModal(false);
          }, 1500);
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
  };
  useEffect(async () => {
    await axios
      .get(`${apiUrl}/admin/teacher/list`)
      .then((response) => {
        setListTeacher(response.data.data)
        setIdTeacher(response.data.data[0].user_id);
      })
      .catch((error) => {

      });
  }, []);
  return (
    <div className="modalBackground" style={{overflow: "scroll"}}>
      <div className="modalContainer" style={{minHeight: "800px", marginTop: "100px"}}>
        <span
          className="close-icon"
          onClick={() => {
            setOpenModal(false);
          }}
        >
          &times;
        </span>
        <h2 style={{ color: "#202020" }}>Thêm khóa học mới</h2>
        <div className="d-flex">
            <input
            type="text"
            placeholder="Tên khóa học"
            className="input-text"
            onChange={(e) => setName(e.target.value)}
          ></input>
          
          <input
            type="text"
            placeholder="Số lương học viên tối đa"
            className="input-text"
            onChange={(e) => setMax(e.target.value)}
          ></input> 
          
        </div>

        <select
          style={{ marginTop: "20px" }}
          className="select-course"
          name="course"
          onChange={(e) => {
            setIdTeacher(e.target.value);
          }}
        >
          {listTeacher &&
            listTeacher.map((e, index) => {
              return (
                <>
                <option value="" disabled selected hidden>Chọn giảng viên</option>
                <option key={index} value={e.user_id}>
                  {e.name}
                </option>
                </>
              );
            })}
        </select>
        <div className="d-flex">
          <input
            type="date"
            placeholder="Start day"
            className="input-text"
            onChange={(e) => setStart(e.target.value)}
          ></input>

          <input
            type="date"
            placeholder="End day"
            className="input-text"
            onChange={(e) => setEnd(e.target.value)}
          ></input>
        </div>
        <div className="d-flex">

<textarea
            type="date"
            placeholder="Mô tả"
            className="input-text"
            name="description"
            onChange={(e) => setDesc(e.target.value)}
          ></textarea>
        </div>  
        {/* <div  className="modalBody">
       <textarea
            type="text"
            placeholder="Mô tả"
            className="input-text"
            name="description"
            value={cate.description}
            onChange={onChangeInput}
          ></textarea>
       </div> */}
       
        <div className="modalBody">
          <img src={imageprev} className="add-cate__img" alt="IMG"></img>
          <label for="file" className="add-cate__label d-flex justify-content-center align-items-center">
            TẢI HÌNH ẢNH LÊN
            <input
              type="file"
              id="file"
              name=""
              className="add-product__file"
              hidden
              accept="image/png, image/jpeg"
              onChange={(e) => changeImage(e)}
            ></input>
          </label>
        </div>
       

        <div className="modalFooter">
          <button
            className="buton-add"
            // onClick={() => {
            //   setOpenModal(false);}}
            onClick={() => handleOnclick()}
          >
            Thêm
          </button>
          <button
            className="button-delete"
            onClick={() => {
              setOpenModal(false);
            }}
            id="cancelBtn"
          >
            Hủy
          </button>
        </div>
      </div>
      <ToastContainer
        position="top-right"
        autoClose={2000}
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
  );
}

export default AddcateModal;
