import React, { useState, useEffect } from "react";

import EditProduct from "../pages/Login/EditProduct.jsx";
import ProductDetail from "./ProductDetail";
import { apiUrl } from '../context/Constants';

import axios from "axios";

import { ToastContainer, toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";

export default function Product({
  id,
  img,
  name,
  content,
  course_name,
  setValue,
  showAction,
}) {
  const delproduct = async (id) => {
    toast.dismiss();
    try {
      const res = await axios.post(
        `${apiUrl}/admin/product/delete/${id}`
      );
      if (res.data) {
        toast(res.data.message);
        setValue(true);
      }
    } catch (error) {
      toast(error.response.data.message);
    }
  };
  async function deleteCate(id) {
    await axios
      .post(`${apiUrl}/admin/product/delete/${id}`)
      .then(async (response) => {
        toast(response.data.message);
        if (response.data.success) {
          // setValue(true);
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

  // async function delproduct(id) {
  //   await axios
  //     .post(`http://192.168.1.129:81/api/admin/product/delete/${id}`)
  //     .then(async (response) => {
  //       setValue(true);
  //       if (response.data.success) {
  //         toast(response.data.mesage);
  //         await fetchData();
  //       } else {
  //         toast(response.data.message);
  //       }
  //     })
  //     .catch((error) => {
  //       if (error.response) {
  //         toast(error.response.data.message);
  //       } else {
  //         toast("Error");
  //       }
  //     });
  // }

  // useEffect(() => {
  //   fetchData();
  // }, [value]);
  // http://192.168.1.129:81/api/admin/product/delete/${id}

  const [editmodalOpen, setEditmodalOpen] = useState(false);
  const [addmodalOpen, setAddmodalOpen] = useState(false);
  // const [value, setValue] = useState(false);

  if (addmodalOpen) {
    document.documentElement.style.overflow = "hidden";
  } else {
    document.documentElement.style.overflow = "auto";
  }
  const setModal = () => {
    setEditmodalOpen(!editmodalOpen);
    setAddmodalOpen(false);
  };
  return (
    <>
      <div className="product-box">
        {addmodalOpen ? (
          <ProductDetail
          id={id}
            img={img}
            name={name}
            content={content}
            course_name={course_name}
            setOpenModal={setAddmodalOpen}
          />
        ) : null}
        <div className="wrapper" onClick={() => setAddmodalOpen(!addmodalOpen)}>
          <div className="product-img">
            <img src={img} alt="kh" />
          </div>
          <div className="product-description" style={{ textAlign: "center" }}>
            <h5>{name}</h5>
          </div>
          
        </div>
        {!showAction 
        ? <div  style={{textAlign: "center"}}>
        <button 
          style={{
            width: "75px",
            marginRight: "5px",
            paddingTop: "7px",
            paddingBottom: "7px",
            backgroundColor: "green",
            borderRadius: "8px",
            color: "white"
          }} 
          onClick={()=>setEditmodalOpen(!editmodalOpen)}
        >
          Sửa
        </button>
        <button 
          style={{
            width: "75px",
            paddingTop: "7px",
            paddingBottom: "7px",
            backgroundColor: "red",
            borderRadius: "8px",
            color: "white"
          }}
          onClick={()=>deleteCate(id)}
        >
          Xóa
        </button>  
        </div>
        : null
        }
        
        
        {/* <div className="product-action">
          <div className="edit-action">
            <button onClick={() => setModal()}>
              <i
                className="bx bx-edit"
                style={{ fontSize: "20px", lineHeight: 1.5 }}
              />
            </button>
          </div>
          <div className="delete-action">
            <button onClick={() => delproduct(id)}>
              <i
                className="bx bx-trash"
                style={{ fontSize: "20px", lineHeight: 1.5 }}
              />
            </button>
          </div>
        </div> */}
      </div>
      {editmodalOpen ? (
        <EditProduct
          setOpenModal={setEditmodalOpen}
          setAddmodalOpen={setAddmodalOpen}
          idProduct={id}
          id={id}
          img={img}
          name={name}
          content={content}
          setValue={setValue}
        />
      ) :null}
    </>
  );
}