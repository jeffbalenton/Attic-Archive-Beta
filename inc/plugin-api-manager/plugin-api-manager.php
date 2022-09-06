<?php
/**
 * An event subscriber who can use the WordPress event manager to 
 * trigger additional event.
 *
 * @author Carl Alexander <carlalexander@helthe.co>
 */
interface EventManagerAwareSubscriberInterface extends SubscriberInterface {
  /**
   * Set the WordPress event manager for the subscriber.
   *
   * @param EventManager $event_manager
   */
  public function set_event_manager( EventManager $event_manager );
}


/**
 * A Subscriber knows what specific WordPress plugin API hooks it wants to register to.
 * 
 * When an EventManager adds a Subscriber, it gets all the hooks that it wants to 
 * register to. It then registers the subscriber as a callback with the WordPress 
 * plugin API for each of them.
 *
 * @author Carl Alexander <contact@carlalexander.ca>
 */
interface SubscriberInterface {
  /**
   * Returns an array of hooks that this subscriber wants to register with
   * the WordPress plugin API.
   *
   * The array key is the name of the hook. The value can be:
   *
   *  * The method name
   *  * An array with the method name and priority
   *  * An array with the method name, priority and number of accepted arguments
   *
   * For instance:
   *
   *  * array('hook_name' => 'method_name')
   *  * array('hook_name' => array('method_name', $priority))
   *  * array('hook_name' => array('method_name', $priority, $accepted_args))
   *
   * @return array
   */
  public static function get_subscribed_hooks();

}
if ( !class_exists( 'PluginAPIManager' ) ):
class PluginAPIManager{
/**
     * Adds a callback to a specific hook of the WordPress plugin API.
     *
     * @uses add_filter()
     *
     * @param string   $hook_name
     * @param callable $callback
     * @param int      $priority
     * @param int      $accepted_args
     */
    public function add_callback( $hook_name, $callback, $priority = 10, $accepted_args = 1 ) {
      add_filter( $hook_name, $callback, $priority, $accepted_args );
    }

    /**
     * Add an event subscriber.
     *
     * The event manager registers all the hooks that the given subscriber
     * wants to register with the WordPress Plugin API.
     *
     * @param SubscriberInterface $subscriber
     */
    public function add_subscriber( SubscriberInterface $subscriber ) {
      if ( $subscriber instanceof EventManagerAwareSubscriberInterface ) {
        $subscriber->set_event_manager( $this );
      }

      foreach ( $subscriber->get_subscribed_hooks() as $hook_name => $parameters ) {
        $this->add_subscriber_callback( $subscriber, $hook_name, $parameters );
      }
    }

    /**
     * Executes all the callbacks registered with the given hook.
     *
     * @uses do_action()
     *
     * @param string $hook_name
     */
    public function execute() {
      $args = func_get_args();
      return call_user_func_array( 'do_action', $args );
    }

    /**
     * Filters the given value by applying all the changes from the callbacks
     * registered with the given hook. Returns the filtered value.
     *
     * @uses apply_filters()
     *
     * @param string $hook_name
     * @param mixed  $value
     *
     * @return mixed
     */
    public function filter() {
      $args = func_get_args();
      return call_user_func_array( 'apply_filters', $args );
    }

    /**
     * Get the name of the hook that WordPress plugin API is executing. Returns
     * false if it isn't executing a hook.
     *
     * @uses current_filter()
     *
     * @return string|bool
     */
    public function get_current_hook() {
      return current_filter();
    }

    /**
     * Checks the WordPress plugin API to see if the given hook has
     * the given callback. The priority of the callback will be returned
     * or false. If no callback is given will return true or false if
     * there's any callbacks registered to the hook.
     *
     * @uses has_filter()
     *
     * @param string $hook_name
     * @param mixed  $callback
     *
     * @return bool|int
     */
    public function has_callback( $hook_name, $callback = false ) {
      return has_filter( $hook_name, $callback );
    }

    /**
     * Removes the given callback from the given hook. The WordPress plugin API only
     * removes the hook if the callback and priority match a registered hook.
     *
     * @uses remove_filter()
     *
     * @param string   $hook_name
     * @param callable $callback
     * @param int      $priority
     *
     * @return bool
     */
    public function remove_callback( $hook_name, $callback, $priority = 10 ) {
      return remove_filter( $hook_name, $callback, $priority );
    }

    /**
     * Remove an event subscriber.
     *
     * The event manager removes all the hooks that the given subscriber
     * wants to register with the WordPress Plugin API.
     *
     * @param SubscriberInterface $subscriber
     */
    public function remove_subscriber( SubscriberInterface $subscriber ) {
      foreach ( $subscriber->get_subscribed_hooks() as $hook_name => $parameters ) {
        $this->remove_subscriber_callback( $subscriber, $hook_name, $parameters );
      }
    }

    /**
     * Adds the given subscriber's callback to a specific hook
     * of the WordPress plugin API.
     *
     * @param SubscriberInterface $subscriber
     * @param string              $hook_name
     * @param mixed               $parameters
     */
    private function add_subscriber_callback( SubscriberInterface $subscriber, $hook_name, $parameters ) {
      if ( is_string( $parameters ) ) {
        $this->add_callback( $hook_name, array( $subscriber, $parameters ) );
      } elseif ( is_array( $parameters ) && isset( $parameters[ 0 ] ) ) {
        $this->add_callback( $hook_name, array( $subscriber, $parameters[ 0 ] ), isset( $parameters[ 1 ] ) ? $parameters[ 1 ] : 10, isset( $parameters[ 2 ] ) ? $parameters[ 2 ] : 1 );
      }
    }

    /**
     * Removes the given subscriber's callback to a specific hook
     * of the WordPress plugin API.
     *
     * @param SubscriberInterface $subscriber
     * @param string              $hook_name
     * @param mixed               $parameters
     */
    private function remove_subscriber_callback( SubscriberInterface $subscriber, $hook_name, $parameters ) {
      if ( is_string( $parameters ) ) {
        $this->remove_callback( $hook_name, array( $subscriber, $parameters ) );
      } elseif ( is_array( $parameters ) && isset( $parameters[ 0 ] ) ) {
        $this->remove_callback( $hook_name, array( $subscriber, $parameters[ 0 ] ), isset( $parameters[ 1 ] ) ? $parameters[ 1 ] : 10 );
      }	
}
 
}
endif;
