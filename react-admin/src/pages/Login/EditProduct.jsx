import React, { useState, useEffect } from "react";
import "../../components/modal/modal.css";
import "./AddProduct.css";
import upload from "../../assets/images/upload1.jpg";
import axios from "axios";
import { ToastContainer, toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
import { apiUrl } from '../../context/Constants'

function EditProduct({ setOpenModal, idProduct, setValue, setAddmodalOpen ,      id,
  img,
  name,
  content}) {
  const [userlist, setUserlist] = useState();
  const [cateList, setCatelist] = useState();
  const [owner_id, setOwner_id] = useState(null);
  const [cate, setCate] = useState(null);
  const [imageprev, setImageprev] = useState(upload);
  const [image, setImage] = useState(upload);
  const [product, setProduct] = useState({
    title: name,
    image: img,
    content: content,
  });
  const onChangeInput = (event) => {
    setProduct({ ...product, [event.target.name]: event.target.value });
  };
console.log(img); 
   function fetchData() {
  
    setImageprev(img);
  }

  useEffect(() => {
    fetchData();
  }, []);

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
    formData.append("title", product.title ? product.title : "");
    formData.append(
      "content",
      product.content ? product.content : ""
    );
    formData.append("image", image ? image : "");

    const data = await axios
      .post(
        `${apiUrl}/admin/product/update/${idProduct}`,
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
    <div
      className="add-product"
      onClick={() => {
        setAddmodalOpen(false);
      }}
    >
      <div className="add-product_layout">
        <h2>Chỉnh sửa thông tin bài giảng</h2>
        <span
          className="close-icon"
          onClick={() => {
            setOpenModal(false);
          }}
        >
          &times;
        </span>
        <div className="add-product_top">
          <div className="add-product_left">
            <input
              className="add-product__input"
              placeholder="Title"
              name="title"
              autofocus="true"
              value={product.title}
              onChange={onChangeInput}
            ></input>
            <textarea
              className="add-product__short-description"
              placeholder="Description"
              name="content"
              value={product.content}
              onChange={onChangeInput}
            ></textarea>
          </div>
          <div className="add-product_right">
            <img src={imageprev} className="add-product__img" alt="IMG"></img>
            <label for="file" className="add-product__label">
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
        </div>
        {/* <textarea
          className="add-product__textarea"
          placeholder="Description"
        ></textarea> */}
        <div className="add-product__button-group">
          <button
            className="add-product__button-item green-color"
            onClick={() => handleOnclick()}
          >
            Sửa
          </button>
          <button
            className="add-product__button-item red-color"
            onClick={() => {
              setOpenModal(false);
            }}
          >
            Hủy
          </button>
        </div>
      </div>
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
      {/* Same as */}
      <ToastContainer />
    </div>
  );
}

export default EditProduct;
