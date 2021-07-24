package sk.tuke.edoklad.activities;

import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.drawable.BitmapDrawable;
import android.net.Uri;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Base64;
import android.util.Log;
import android.view.KeyEvent;
import android.view.View;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.ProgressBar;
import android.widget.TextView;

import com.android.volley.AuthFailureError;
import com.android.volley.DefaultRetryPolicy;
import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;

import com.theartofdev.edmodo.cropper.CropImage;
import net.gotev.uploadservice.UploadService;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.ByteArrayOutputStream;
import java.util.HashMap;
import java.util.Map;

import sk.tuke.edoklad.R;
import sk.tuke.edoklad.classes.PhotoSingleton;

public class Camera extends AppCompatActivity implements View.OnClickListener {
    private ImageView imageView;
    private ImageButton btnCamera, btnUpload;
    private LinearLayout obrazky, texty;
    private Bitmap bitmap;
    private String email, pass;
    private String TAG = "Camera activity";

    private ProgressBar bar;
    private TextView uploadText;
    private String responseFromServer;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_camera);

        bar = findViewById(R.id.progressBar);
        btnCamera = findViewById(R.id.btnCamera);
        imageView = findViewById(R.id.photoView);
        btnUpload = findViewById(R.id.uploadButton);
        obrazky = findViewById(R.id.obrazky);
        texty = findViewById(R.id.texty);
        uploadText = findViewById(R.id.uploadProgressBar);
        UploadService.NAMESPACE = "sk.tuke.edoklad";

        btnCamera.setOnClickListener(this);
        btnUpload.setOnClickListener(this);
    }

    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
        if (requestCode == CropImage.CROP_IMAGE_ACTIVITY_REQUEST_CODE) {
            CropImage.ActivityResult result = CropImage.getActivityResult(data);
            if (resultCode == RESULT_OK) {
                Uri resultUri = result.getUri();
                imageView.setImageURI(resultUri);
            } else if (resultCode == CropImage.CROP_IMAGE_ACTIVITY_RESULT_ERROR_CODE) {
                Exception error = result.getError();
            }
            obrazky.setVisibility(View.GONE);
            texty.setVisibility(View.GONE);
            btnUpload.setVisibility(View.VISIBLE);
        }
    }

    protected void exitByBackKey() {
        AlertDialog alertbox = new AlertDialog.Builder(this)
                .setMessage("Chcete sa vrátiť na hlavnú obrazovku?")
                .setPositiveButton("Áno", new DialogInterface.OnClickListener() {
                    public void onClick(DialogInterface arg0, int arg1) {
                        Intent intent = new Intent(Camera.this, Dashboard.class);
                        intent.putExtra("email", email);
                        intent.putExtra("pass", pass);
                        startActivity(intent);
                    }
                })
                .setNegativeButton("Nie", new DialogInterface.OnClickListener() {
                    public void onClick(DialogInterface arg0, int arg1) {
                    }
                })
                .show();
    }

    public boolean onKeyDown(int keyCode, KeyEvent event) {
        if (keyCode == KeyEvent.KEYCODE_BACK) {
            exitByBackKey();
            return true;
        }
        return super.onKeyDown(keyCode, event);
    }

    @Override
    public void onClick(View v) {
        if (v == btnCamera){
            CropImage.activity().start(this);
        }
        if (v == btnUpload){
            uploadImage();
        }
    }

    private void uploadImage(){
        bitmap = ((BitmapDrawable) imageView.getDrawable()).getBitmap();
        String uploadURL = "http://147.232.174.113/upload";
        StringRequest stringRequest = new StringRequest(Request.Method.POST, uploadURL, new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                try {
                    JSONObject jsonObject = new JSONObject(response);
                    responseFromServer = response;
                    openForm();
                } catch (JSONException e) {
                    e.printStackTrace();
                }
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Log.e(TAG,error.toString());
            }
        }){
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                email = getIntent().getStringExtra("email");
                pass = getIntent().getStringExtra("pass");

                Map<String,String> parameters = new HashMap<>();
                parameters.put("email", email);
                parameters.put("pass", pass);
                parameters.put("image", imgToString(bitmap));

                return parameters;
            }
        };
        stringRequest.setRetryPolicy(new DefaultRetryPolicy(30000,
                DefaultRetryPolicy.DEFAULT_MAX_RETRIES,
                DefaultRetryPolicy.DEFAULT_BACKOFF_MULT));

        PhotoSingleton.getInstance(Camera.this).addToRequestQueue(stringRequest);
        bar.setVisibility(View.VISIBLE);
        uploadText.setVisibility(View.VISIBLE);
        btnCamera.setVisibility(View.GONE);
        btnUpload.setVisibility(View.GONE);
    }

    private String imgToString(Bitmap bitmap){
        ByteArrayOutputStream byteArrayOutputStream = new ByteArrayOutputStream();
        bitmap.compress(Bitmap.CompressFormat.JPEG, 100, byteArrayOutputStream);
        byte[] imgBytes = byteArrayOutputStream.toByteArray();
        return Base64.encodeToString(imgBytes,Base64.DEFAULT);
    }

    private void openForm(){
        Intent intent = new Intent(this, Form.class);
        intent.putExtra("odozva",responseFromServer);
        intent.putExtra("email", email);
        intent.putExtra("pass", pass);
        startActivity(intent);
    }
}