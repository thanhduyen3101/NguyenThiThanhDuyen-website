import React, { useState } from "react";

import Table from "../components/table/Table";

import { DateTimePicker } from "react-rainbow-components";

import salemanrevenueList from "../assets/JsonData/saleman-revenue-list.json";

const salemanrevenueTableHead = [
  "ID Order",
  "store",
  "sub total",
  "created_at",
  "updated_at",
];

const renderHead = (item, index) => <th key={index}>{item}</th>;

const renderBody = (item, index) => (
  <tr key={index}>
    <td>{item.id_order}</td>
    <td>{item.store}</td>
    <td>{item.sub_total}</td>
    <td>{item.created_at}</td>
    <td>{item.updated_at}</td>
  </tr>
);

const Saleman_Revenue = () => {
  const initialState = {
    value: new Date("2021-10-25 10:44"),
    // locale: { name: 'en-US', label: 'English (US)' },
  };

  const [state, setState] = useState(initialState);

  const containerStyles = {
    maxWidth: 250,
  };

  return (
    <div>
      <h2 className="page-header">Saleman : Darrell Williamson</h2>
      <div className="orderDetail__header">
        <p>
          ID<span className="orderDetail__header-title">123</span>
        </p>
        <p>
          Email<span className="orderDetail__header-title">abc@gmail.com</span>
        </p>
        <p>
          Area<span className="orderDetail__header-title">Hai Chau</span>
        </p>
        <p>
          Total<span className="orderDetail__header-title">300 $</span>
        </p>
      </div>
      <div className="row">
        <div className="col-12">
          <div className="card">
            {/* <div className="card__header">
                            <div>                                                            
                                <div
                                    className="rainbow-align-content_center rainbow-m-vertical_large rainbow-p-horizontal_small rainbow-m_auto"
                                    style={containerStyles}
                                >
                                    <DateTimePicker
                                        className="datetimepicker"
                                        // label="DateTimePicker label"
                                        value={state.value}
                                        onChange={value => setState({ value })}
                                        formatStyle="medium"
                                        locale={"en-US"}
                                        okLabel={"OK"}
                                        cancelLabel={"Cancel"}
                                    />
                                </div>
                            </div>
                        </div> */}
            <div className="card__body">
              <Table
                limit="5"
                headData={salemanrevenueTableHead}
                renderHead={(item, index) => renderHead(item, index)}
                bodyData={salemanrevenueList}
                renderBody={(item, index) => renderBody(item, index)}
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Saleman_Revenue;
