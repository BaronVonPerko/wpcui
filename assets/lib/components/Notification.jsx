import React from "react";
import { connect } from "react-redux";
import store, { actions } from "../redux/wpcuiReducer";

export const messages = {
  SAVE_SUCCESS: "Changes saved successfully!",
};

class Notification extends React.Component {
  startTimer() {
    setTimeout(() => {
      store.dispatch({ type: actions.NOTIFY });
    }, 3000);
  }

  render() {
    if (this.props.notification?.message) {
      this.startTimer();
      return <div className="wpcui-notification-box">ALERT ALERT</div>;
    } else return null;
  }
}

const mapStateToProps = (state) => ({
  notification: state.notification,
});

export default connect(mapStateToProps)(Notification);
