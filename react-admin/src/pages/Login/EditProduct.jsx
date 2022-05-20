import React, { useState, useEffect } from "react";
import "../../components/modal/modal.css";
import "./AddProduct.css";
import upload from "../../assets/images/upload1.jpg";
import axios from "axios";
import { ToastContainer, toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
import { apiUrl } from '../../context/Constants'

function EditProduct({ setOpenModal, idProduct, setValue, setAddmodalOpen }) {
  const [userlist, setUserlist] = useState();
  const [cateList, setCatelist] = useState();
  const [owner_id, setOwner_id] = useState(null);
  const [cate, setCate] = useState(null);
  const [imageprev, setImageprev] = useState(upload);
  const [image, setImage] = useState(upload);
  const [product, setProduct] = useState({
    title: "",
    image: "",
    price: "",
    description: "",
    size: "",
    category: "",
    owner_id: "",
  });

  const onChangeInput = (event) => {
    setProduct({ ...product, [event.target.name]: event.target.value });
  };

  async function fetchData() {
    const response2 = await axios.get(
      `${apiUrl}/product/detail/${idProduct}`
    );
    setProduct(response2.data.data);
    if (response2.data.data && response2.data.data.image) {
      setImageprev(response2.data.data.image);
    }

    const response = await axios.get(
      `${apiUrl}/admin/user/shop/list`
    );
    setUserlist(response.data.data);

    const response1 = await axios.get(
      `${apiUrl}/category/list`
    );
    setCatelist(response1.data.data);
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
      "owner_id",
      product.owner_id ? product.owner_id : userlist[0].user_id
    );
    formData.append(
      "category",
      product.category ? product.category : cateList[0].category_id
    );
    formData.append("size", product.size ? product.size : "");
    formData.append("price", product.price ? product.price : "");
    formData.append(
      "description",
      product.description ? product.description : ""
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
        <h2>Edit Product</h2>
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
            <select
              className="add-product__input"
              name="owner_id"
              id="id"
              value={product.owner_id}
              onChange={onChangeInput}
            >
              {userlist &&
                userlist.map((e) => {
                  return (
                    <option key={e.user_id} value={e.user_id}>
                      {e.name}
                    </option>
                  );
                })}
            </select>
            <select
              className="add-product__input"
              name="category"
              id="cate"
              value={product.category}
              onChange={onChangeInput}
            >
              {cateList &&
                cateList.map((e) => {
                  return (
                    <option key={e.category_id} value={e.category_id}>
                      {e.name}
                    </option>
                  );
                })}
            </select>
            <div className="add-product__group">
              <input
                className="add-product__input-item"
                placeholder="Price"
                name="price"
                value={product.price}
                onChange={onChangeInput}
              ></input>
              <input
                className="add-product__input-item"
                placeholder="Size"
                value={product.size}
                name="size"
                onChange={onChangeInput}
              ></input>
            </div>
            <textarea
              className="add-product__short-description"
              placeholder="Description"
              name="description"
              value={product.description}
              onChange={onChangeInput}
            ></textarea>
          </div>
          <div className="add-product_right">
            <img src={imageprev} className="add-product__img" alt="IMG"></img>
            <label for="file" className="add-product__label">
              UPLOAD PRODUCT IMAGE
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
            Edit
          </button>
          <button
            className="add-product__button-item red-color"
            onClick={() => {
              setOpenModal(false);
            }}
          >
            Cancel
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
