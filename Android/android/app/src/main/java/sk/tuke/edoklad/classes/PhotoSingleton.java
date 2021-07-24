package sk.tuke.edoklad.classes;

import android.content.Context;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.toolbox.Volley;

public class PhotoSingleton {
    private static PhotoSingleton mInstance;
    private static Context mContext;
    private RequestQueue requestQueue;

    public PhotoSingleton(Context context) {
        mContext = context;
        requestQueue = getRequestQueue();
    }

    private RequestQueue getRequestQueue(){
        if(requestQueue == null){
            requestQueue = Volley.newRequestQueue(mContext.getApplicationContext());
        }
        return requestQueue;
    }

    public static synchronized PhotoSingleton getInstance(Context context){
        if(mInstance == null){
            mInstance = new PhotoSingleton(context);
        }
        return mInstance;
    }

    public<T> void addToRequestQueue(Request<T> request){
        getRequestQueue().add(request);
    }
}
