import React from "react";
import { connect } from "react-redux";
import store, { actions } from "../redux/wpcuiReducer";

export const messages = {
  SAVE_SUCCESS: "Changes saved successfully!",
};

class Notification extends React.Component {
  constructor(props) {
    super(props);

    this.state = { fade: false };
  }

  startTimer() {
    setTimeout(() => {
      this.setState({ fade: true });
    }, 3000);

    setTimeout(() => {
      store.dispatch({ type: actions.CLEAR_NOTIFICATION });
    }, 4000);
  }

  getClass() {
    return `wpcui-notification-box ${this.state.fade ? "wpcui-invisible" : ""}`;
  }

  render() {
    if (this.props.notification?.message) {
      this.startTimer();
      return (
        <div className={this.getClass()}>{this.props.notification.message}</div>
      );
    }
    return null;
  }
}

const mapStateToProps = (state) => ({
  notification: state.notification,
});

export default connect(mapStateToProps)(Notification);
