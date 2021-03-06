import React, { useEffect, useState } from "react";
import "./modal.css";

import upload from "../../assets/images/upload1.jpg";
import axios from "axios";
import { apiUrl } from "../../context/Constants";
import { ToastContainer, toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";

function EditcateModal({ setOpenModal, setValue, idCate }) {
  const [image, setImage] = useState(upload);
  const [cateList, setCatelist] = useState();
  const [imageprev, setImageprev] = useState(upload);
  const [listTeacher, setListTeacher] = useState();
  const [cate, setCate] = useState({
    name: "",
    maximum_student: "",
    start_day: "",
    end_day: "",
    description: "",
    id_teacher: "",
    image: "",
  });
  const onChangeInput = (event) => {
    setCate({ ...cate, [event.target.name]: event.target.value });
    console.log(cate);
  };
  async function fetchData() {
    const response2 = await axios.get(
      `${apiUrl}/admin/category/detail/${idCate}}`
    );
    await axios
      .get(`${apiUrl}/admin/teacher/list`)
      .then((response) => {
        setListTeacher(response.data.data)
      })
      .catch((error) => {

      });
    setCate(response2.data.data);
    if (response2.data.data && response2.data.data.image) {
      setImageprev(response2.data.data.image);
    }

    // const response = await axios.get(
    //   `http://192.168.1.129:81/api/admin/user/shop/list`
    // );
    // setUserlist(response.data.data);

    // const response1 = await axios.get(
    //   `http://192.168.1.129:81/api/category/list`
    // );
    // setCatelist(response1.data.data);
  }
  useEffect(() => {
    fetchData();
  }, []);

  const changeImage = (event) => {
    var file = event.target.files[0];
    console.log(file);
    setImage(file);
    var reader = new FileReader();
    reader.readAsDataURL(file);
    setImageprev("");
    reader.onloadend = function (e) {
      setImageprev(reader.result);
    }.bind(this);
  };
  const handleOnclick = async () => {
    const formData = new FormData();

    formData.append("name", cate.name ? cate.name : "");
    formData.append("maximum_student", cate.maximum_student ? cate.maximum_student : "");
    formData.append("start_day", cate.start_day ? cate.start_day : "");
    formData.append("end_day", cate.end_day ? cate.end_day : "");
    formData.append("description", cate.description ? cate.description : "");
    formData.append("id_teacher", cate.id_teacher ? cate.id_teacher : "");

    formData.append("image", image ? image : "");

    const data = await axios
      .post(
        `${apiUrl}/admin/category/update/${idCate}`,
        formData
      )
      .then((response) => {
        setValue(true);
        if (response.data.success) {
          toast("update success");
        } else {
          toast(response.data.message);
        }
        setTimeout(() => {
          setOpenModal(false);
        }, 2000);
      })
      .catch((error) => {
        if (error.response) {
          toast(error.response.data.message);
        } else {
          toast("Error");
        }
        setTimeout(() => {
          setOpenModal(false);
        }, 2000);
      });
  };

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
        <h2 style={{ color: "#202020" }}>Ch???nh s???a kh??a h???c</h2>
        <div className="d-flex">
          <input
            type="text"
            placeholder="T??n kh??a h???c"
            name="name"
            value={cate.name}
            className="input-text"
            onChange={onChangeInput}
          ></input>

          <input
            type="text"
            placeholder="S??? l?????ng h???c vi??n t???i ??a"
            className="input-text"
            name="maximum_student"
            value={cate.maximum_student}
            onChange={onChangeInput}
          ></input>
        </div>

        <select
          style={{ marginTop: "20px" }}
          className="select-course"
          name="id_teacher"
          value={cate.id_teacher}
          onChange={onChangeInput}
        >
          {listTeacher &&
            listTeacher.map((e, index) => {
              return (
                <option key={index} value={e.user_id} >
                  {e.name}
                </option>
              );
            })}
        </select>
        <div className="d-flex">
          <input
            type="date"
            name="start_day"
            placeholder="Ng??y b???t ?????u"
            className="input-text"
            value={cate.start_day}
            onChange={onChangeInput}
          ></input>

          <input
            type="date"
            placeholder="Ng??y k???t th??c"
            className="input-text"
            name="end_day"
            value={cate.end_day}
            onChange={onChangeInput}
          ></input>
        </div>
        <textarea
            type="text"
            placeholder="M?? t???"
            className="input-text"
            name="description"
            value={cate.description}
            onChange={onChangeInput}
          ></textarea>
        <div className="modalBody">
          <img src={imageprev} className="add-cate__img" alt="IMG"></img>

          <label for="file" className="add-cate__label d-flex justify-content-center align-items-center">
            T???I H??NH ???NH L??N
            <input
              type="file"
              id="file"
              name=""
              className="add-cate__file"
              hidden
              accept="image/png, image/jpeg"
              onChange={(e) => changeImage(e)}
            ></input>
          </label>
        </div>
        <div className="modalFooter">
          <button
            className="button-edit"
            onClick={() => handleOnclick()}
          >
            S???a
          </button>
          <button
            className="button-delete"
            onClick={() => {
              setOpenModal(false);
            }}
            id="cancelBtn"
          >
            H???y
          </button>
        </div>
      </div>
    </div>
  );
}

export default EditcateModal;
